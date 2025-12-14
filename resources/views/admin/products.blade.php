@extends('layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="min-h-screen animate-fade-in space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">
                Products Management
            </h1>
            <p class="text-slate-600 flex items-center space-x-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="truncate">{{ $branch->name }} - {{ $branch->business->name }}</span>
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                Categories
            </a>
            <button onclick="document.getElementById('product-modal').classList.remove('hidden')" class="btn-primary">
                + New Product
            </button>
            <a href="{{ route(dashboard_route()) }}" class="btn-secondary">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Dashboard
            </a>
        </div>
    </div>

        <!-- Products Table -->
        <div class="card p-3 sm:p-4 md:p-6">
            <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                <div class="inline-block min-w-full align-middle px-3 sm:px-4 md:px-6">
                    <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                        <thead class="bg-gradient-to-r from-slate-50 via-blue-50/30 to-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider">Product</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider hidden sm:table-cell">Category</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider hidden md:table-cell">SKU</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider">Price</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider">Stock</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-all duration-200 border-b border-slate-100">
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                <div class="text-xs sm:text-sm font-semibold text-slate-900">{{ $product->name }}</div>
                                @if($product->description)
                                    <div class="text-[10px] sm:text-xs text-slate-500 font-medium line-clamp-2 hidden sm:block">{{ Str::limit($product->description, 50) }}</div>
                                @endif
                                @if($product->category)
                                    <div class="mt-1 sm:hidden">
                                        <span class="badge badge-info text-[10px]" style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }}; border-color: {{ $product->category->color }}40">
                                            {{ $product->category->icon ?? '' }} {{ $product->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap hidden sm:table-cell">
                                @if($product->category)
                                    <span class="badge badge-info text-[10px] sm:text-xs" style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }}; border-color: {{ $product->category->color }}40">
                                        {{ $product->category->icon ?? '' }} {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">No Category</span>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-xs sm:text-sm font-semibold text-slate-900">{{ $product->sku ?? 'N/A' }}</div>
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm font-extrabold text-slate-900">{{ format_money($product->price) }}</div>
                                @if($product->cost)
                                    <div class="text-[10px] sm:text-xs text-slate-500 hidden sm:block">Cost: {{ format_money($product->cost) }}</div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap">
                                @php
                                    $inventory = $product->inventories->first();
                                    $stock = $inventory->qty ?? 0;
                                    $minThreshold = $inventory->min_threshold ?? 10;
                                @endphp
                                <div class="text-xs sm:text-sm font-extrabold {{ $stock <= $minThreshold ? 'text-red-600' : 'text-slate-900' }}">
                                    {{ $stock }} {{ $product->unit }}
                                </div>
                                @if($stock <= $minThreshold)
                                    <div class="text-[10px] sm:text-xs text-red-500">Low stock</div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap">
                                @if($product->active)
                                    <span class="badge badge-success text-[10px] sm:text-xs">Active</span>
                                @else
                                    <span class="badge badge-warning text-[10px] sm:text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 whitespace-nowrap">
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold hover:underline text-xs sm:text-sm">
                                        Delete
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-slate-500 font-medium">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Product Modal -->
<div id="product-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-2xl w-full mx-4 transform transition-all shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-3xl font-extrabold text-slate-900">Create New Product</h3>
            <button onclick="document.getElementById('product-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.products.create') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Product Name *</label>
                    <input type="text" id="name" name="name" required
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label for="sku" class="block text-sm font-semibold text-slate-700 mb-2">SKU</label>
                    <input type="text" id="sku" name="sku"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium"></textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*"
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-slate-500">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WebP</p>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                <select id="category_id" name="category_id"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                    <option value="">No Category</option>
                    @foreach(\App\Models\Category::where('branch_id', $branch->id)->orWhereNull('branch_id')->where('active', true)->orderBy('name')->get() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Price (₦) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label for="cost" class="block text-sm font-semibold text-slate-700 mb-2">Cost (₦)</label>
                    <input type="number" id="cost" name="cost" step="0.01" min="0"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label for="unit" class="block text-sm font-semibold text-slate-700 mb-2">Unit *</label>
                    <input type="text" id="unit" name="unit" placeholder="e.g., pcs, kg, L" required
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="initial_stock" class="block text-sm font-semibold text-slate-700 mb-2">Initial Stock</label>
                    <input type="number" id="initial_stock" name="initial_stock" min="0" value="0"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label for="min_threshold" class="block text-sm font-semibold text-slate-700 mb-2">Min Threshold</label>
                    <input type="number" id="min_threshold" name="min_threshold" min="0" value="10"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Create Product
                </button>
                <button type="button" onclick="document.getElementById('product-modal').classList.add('hidden')" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

