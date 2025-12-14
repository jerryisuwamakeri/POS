@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-2xl mx-auto">
        <div class="mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Edit Category</h1>
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline text-lg">← Back</a>
        </div>

        <div class="card p-10">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Category Name *</label>
                    <input type="text" name="name" required value="{{ old('name', $category->name) }}" class="input-modern">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Description</label>
                    <textarea name="description" rows="3" class="input-modern">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Color</label>
                        <input type="color" name="color" value="{{ old('color', $category->color) }}" class="w-full h-12 rounded-xl border-2 border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Icon (Emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="input-modern" placeholder="📱 🍔 👕">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" class="input-modern">
                </div>
                <div>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="active" value="1" {{ old('active', $category->active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Active</span>
                    </label>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 btn-primary py-4">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="flex-1 btn-secondary py-4 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

