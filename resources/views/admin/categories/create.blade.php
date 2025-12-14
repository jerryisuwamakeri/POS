@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-2xl mx-auto">
        <div class="mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Create Category</h1>
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline text-lg">← Back</a>
        </div>

        <div class="card p-10">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Category Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="input-modern" placeholder="e.g., Electronics, Food, Clothing">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Description</label>
                    <textarea name="description" rows="3" class="input-modern">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Color</label>
                        <input type="color" name="color" value="{{ old('color', '#3b82f6') }}" class="w-full h-12 rounded-xl border-2 border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Icon (Emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" class="input-modern" placeholder="📱 🍔 👕">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="input-modern">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 btn-primary py-4">Create Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="flex-1 btn-secondary py-4 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

