<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $branch = $user->branch;

        $query = Category::query();

        if ($branch) {
            $query->where(function($q) use ($branch) {
                $q->where('branch_id', $branch->id)
                  ->orWhereNull('branch_id'); // Global categories
            });
        } else {
            $query->whereNull('branch_id');
        }

        $categories = $query->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories', 'branch'));
    }

    public function create()
    {
        $user = Auth::user();
        $branch = $user->branch;
        return view('admin.categories.create', compact('branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $branch = $user->branch;

        Category::create([
            'branch_id' => $branch?->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?? '#3b82f6',
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'active' => true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?? '#3b82f6',
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with products. Please reassign products first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
