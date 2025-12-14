@extends('layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Order Management
                </h1>
                <p class="text-slate-600 font-medium flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    @if($branch)
                        <span>{{ $branch->name }} - {{ $branch->business->name }}</span>
                    @else
                        <span>All Branches</span>
                    @endif
                </p>
            </div>
            <a href="{{ route(dashboard_route()) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                ← Dashboard
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-blue-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Orders</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-emerald-100 text-sm font-semibold mb-2 uppercase tracking-wide">Paid Orders</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['paid'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-amber-500 via-yellow-600 to-orange-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-amber-100 text-sm font-semibold mb-2 uppercase tracking-wide">Pending</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-purple-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Revenue</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ format_money($stats['total_revenue']) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Reference or Customer..."
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                        <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div class="flex items-end">
                    <div class="w-full">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">To Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>
                </div>
                <div class="md:col-span-4 flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Filter Orders
                    </button>
                    <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $order->reference }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $order->customer_name ?? 'Walk-in' }}</div>
                                <div class="text-sm text-slate-500 font-medium">{{ $order->user->display_name ?? $order->user->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $order->orderItems->count() }} items</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-extrabold text-slate-900">{{ format_money($order->total_amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200 capitalize">
                                    {{ str_replace('_', ' ', $order->payment_method) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $order->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                                        View
                                    </a>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold hover:underline">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No orders found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

