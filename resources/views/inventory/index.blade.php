@extends('layouts.app')

@section('title', 'Inventory Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Inventory Management
                </h1>
                <p class="text-slate-600 font-medium flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $branch->name }} - {{ $branch->business->name }}</span>
                </p>
            </div>
            <a href="{{ route(dashboard_route()) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                ← Dashboard
            </a>
        </div>

        <!-- Low Stock Alert -->
        @php
            $lowStockItems = $inventories->filter(function($inv) {
                return $inv->qty <= $inv->min_threshold;
            });
        @endphp
        @if($lowStockItems->count() > 0)
        <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-2xl shadow-xl p-6 mb-8 border border-red-200">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-red-800">Low Stock Alert</h2>
            </div>
            <p class="text-red-700 font-semibold mb-4">{{ $lowStockItems->count() }} product(s) need restocking</p>
        </div>
        @endif

        <!-- Inventory Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Current Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Min Threshold</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($inventories as $inventory)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $inventory->product->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $inventory->product->sku ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-extrabold {{ $inventory->qty <= $inventory->min_threshold ? 'text-red-600' : 'text-slate-900' }}">
                                    {{ $inventory->qty }} {{ $inventory->product->unit }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 font-medium">{{ $inventory->min_threshold }} {{ $inventory->product->unit }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inventory->qty <= 0)
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-200">Out of Stock</span>
                                @elseif($inventory->qty <= $inventory->min_threshold)
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">Low Stock</span>
                                @else
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">In Stock</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="openEditModal({{ $inventory->id }}, '{{ $inventory->product->name }}', {{ $inventory->qty }}, {{ $inventory->min_threshold }})" 
                                        class="text-blue-600 hover:text-blue-700 font-semibold hover:underline mr-3">
                                    Edit
                                </button>
                                <button onclick="openAdjustModal({{ $inventory->id }}, '{{ $inventory->product->name }}', {{ $inventory->qty }})" 
                                        class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline">
                                    Adjust
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No inventory items found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($inventories->hasPages())
            <div class="mt-6">
                {{ $inventories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Inventory Modal -->
<div id="edit-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 transform transition-all shadow-2xl border border-slate-200">
        <h3 class="text-2xl font-extrabold text-slate-900 mb-6" id="edit-product-name">Edit Inventory</h3>
        <form id="edit-form" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Current Quantity *</label>
                <input type="number" name="qty" id="edit-qty" min="0" required
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Minimum Threshold</label>
                <input type="number" name="min_threshold" id="edit-threshold" min="0"
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Update
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adjust Inventory Modal -->
<div id="adjust-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 transform transition-all shadow-2xl border border-slate-200">
        <h3 class="text-2xl font-extrabold text-slate-900 mb-6" id="adjust-product-name">Adjust Stock</h3>
        <form id="adjust-form" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Current Stock</label>
                <input type="text" id="adjust-current" readonly
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 bg-slate-50 text-slate-700 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Adjustment *</label>
                <p class="text-xs text-slate-500 mb-2">Enter positive number to add, negative to remove</p>
                <input type="number" name="adjustment" id="adjust-amount" required
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Reason (Optional)</label>
                <textarea name="reason" rows="3"
                          class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium"></textarea>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Apply Adjustment
                </button>
                <button type="button" onclick="closeAdjustModal()" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, qty, threshold) {
    document.getElementById('edit-product-name').textContent = 'Edit: ' + name;
    document.getElementById('edit-qty').value = qty;
    document.getElementById('edit-threshold').value = threshold;
    document.getElementById('edit-form').action = '{{ url("/inventory") }}/' + id;
    document.getElementById('edit-modal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

function openAdjustModal(id, name, currentQty) {
    document.getElementById('adjust-product-name').textContent = 'Adjust Stock: ' + name;
    document.getElementById('adjust-current').value = currentQty;
    document.getElementById('adjust-form').action = '{{ url("/inventory") }}/' + id + '/adjust';
    document.getElementById('adjust-modal').classList.remove('hidden');
}

function closeAdjustModal() {
    document.getElementById('adjust-modal').classList.add('hidden');
}

// Close modals on outside click
document.getElementById('edit-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
document.getElementById('adjust-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAdjustModal();
});
</script>
@endsection

