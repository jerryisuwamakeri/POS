@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8">
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Product Categories</h1>
                <p class="text-slate-600 font-medium text-lg">Organize your products by categories</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ New Category</a>
                <a href="{{ route('admin.products') }}" class="btn-secondary">← Products</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="card p-6 hover:shadow-2xl transition-all duration-300 animate-scale-in">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        @if($category->icon)
                            <div class="text-3xl">{{ $category->icon }}</div>
                        @else
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold" style="background-color: {{ $category->color }}">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">{{ $category->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</p>
                        </div>
                    </div>
                </div>
                @if($category->description)
                <p class="text-sm text-slate-600 mb-4">{{ $category->description }}</p>
                @endif
                <div class="flex items-center space-x-2 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="flex-1 btn-secondary py-2 text-center text-sm">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-all font-semibold text-sm">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="card p-12 text-center">
                    <p class="text-slate-400 font-medium text-lg mb-4">No categories found</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn-primary inline-block">Create First Category</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

