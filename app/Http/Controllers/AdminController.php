<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show users management
     */
    public function users()
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        $query = User::query();

        // Super admin can see all users, admin can only see users from their branch
        if ($branch) {
            $query->where('branch_id', $branch->id);
        }
        // If no branch (super admin), show all users including those without branches

        $users = $query->with(['branch.business', 'roles'])
            ->orderBy('name')
            ->paginate(20);

        // Get available branches for user creation
        $availableBranches = Branch::query();
        if ($branch) {
            // Admin can only see their branch
            $availableBranches->where('id', $branch->id);
        }
        // Super admin can see all branches
        $availableBranches = $availableBranches->with('business')->orderBy('name')->get();

        // Get available roles
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();

        return view('admin.users', compact('users', 'branch', 'availableBranches', 'roles'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $user = Auth::user();
        $branch = $user->branch;

        // Get available branches
        $availableBranches = Branch::query();
        if ($branch) {
            $availableBranches->where('id', $branch->id);
        }
        $availableBranches = $availableBranches->with('business')->orderBy('name')->get();

        // Get available roles
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();

        return view('admin.users.create', compact('availableBranches', 'roles', 'branch'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $currentUser = Auth::user();
        $currentBranch = $currentUser->branch;

        // Branch validation
        $branchId = $request->branch_id;
        if ($currentBranch) {
            // Admin can only create users for their branch
            if ($branchId != $currentBranch->id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'You can only create users for your branch.');
            }
        }
        // Super admin can create users for any branch or no branch

        // Get the role
        $role = \Spatie\Permission\Models\Role::findOrFail($request->role_id);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'display_name' => $request->display_name ?? $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'branch_id' => $branchId,
        ]);

        // Assign role
        $user->assignRole($role);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show products management
     */
    public function products()
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        // Get all products for this branch (admin can see all, including inactive)
        $products = Product::where('branch_id', $branch->id)
            ->with(['inventories' => function ($query) use ($branch) {
                $query->where('branch_id', $branch->id);
            }, 'category'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.products', compact('products', 'branch'));
    }

    /**
     * Create product
     */
    public function createProduct(Request $request)
    {
        // Role middleware already handles authorization

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'initial_stock' => 'nullable|integer|min:0',
            'min_threshold' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->back()->with('error', 'Branch not selected');
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
        }

        $product = Product::create([
            'branch_id' => $branch->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => to_kobo($request->price),
            'cost' => to_kobo($request->cost ?? 0),
            'unit' => $request->unit,
            'active' => true,
        ]);

        // Create inventory
        \App\Models\Inventory::create([
            'branch_id' => $branch->id,
            'product_id' => $product->id,
            'qty' => $request->initial_stock ?? 0,
            'min_threshold' => $request->min_threshold ?? 10,
        ]);

        return redirect()->back()->with('success', 'Product created successfully');
    }

    /**
     * Delete product
     */
    public function deleteProduct(Product $product)
    {
        // Role middleware already handles authorization
        
        $user = Auth::user();
        $branch = $user->branch;

        // Ensure user can only delete products from their branch (unless super admin)
        if ($branch && $product->branch_id !== $branch->id && !$user->hasRole('super_admin')) {
            return redirect()->back()->with('error', 'You can only delete products from your branch.');
        }

        // Delete associated inventory
        $product->inventories()->delete();

        // Delete product image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $user->syncRoles([$role]);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Role assigned successfully');
    }

    /**
     * Assign permission to user
     */
    public function assignPermission(Request $request, User $user)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $permission = Permission::findOrFail($request->permission_id);
        $user->givePermissionTo($permission);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Permission assigned successfully');
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(Request $request, User $user)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $permission = Permission::findOrFail($request->permission_id);
        $user->revokePermissionTo($permission);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Permission revoked successfully');
    }
}

