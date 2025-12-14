<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions
     */
    public function index()
    {
        $permissions = Permission::withCount('roles')
            ->orderBy('name')
            ->get();

        // Group permissions by category
        $grouped = $permissions->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[0]; // First word as category
        });

        return view('admin.permissions.index', compact('permissions', 'grouped'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified permission
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');
        $allRoles = Role::orderBy('name')->get();
        
        return view('admin.permissions.show', compact('permission', 'allRoles'));
    }

    /**
     * Show the form for editing the specified permission
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission)
    {
        if ($permission->roles->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete permission assigned to roles. Please remove from roles first.');
        }

        $permission->delete();

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}

