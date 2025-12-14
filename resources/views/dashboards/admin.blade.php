@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen animate-fade-in">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-1 sm:mb-2">
            Admin Dashboard
        </h1>
        <p class="text-slate-600 flex items-center space-x-2 text-xs sm:text-sm">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="truncate">{{ $branch->name }} - {{ $branch->business->name }}</span>
        </p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6 lg:mb-8">
            <a href="{{ route('pos.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-brand-husk to-brand-teak rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 text-white shadow-md hover:shadow-lg transition-all duration-200 border-0">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-base sm:text-lg mb-0.5 sm:mb-1 truncate">POS Terminal</p>
                        <p class="text-brand-off-yellow text-xs sm:text-sm truncate">New Sale</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('orders.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 text-white shadow-md hover:shadow-lg transition-all duration-200 border-0">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-base sm:text-lg mb-0.5 sm:mb-1 truncate">Orders</p>
                        <p class="text-emerald-100 text-xs sm:text-sm truncate">View All</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.products') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 text-white shadow-md hover:shadow-lg transition-all duration-200 border-0">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-base sm:text-lg mb-0.5 sm:mb-1 truncate">Products</p>
                        <p class="text-purple-100 text-xs sm:text-sm truncate">Manage</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('inventory.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-amber-600 to-orange-600 rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 text-white shadow-md hover:shadow-lg transition-all duration-200 border-0">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-base sm:text-lg mb-0.5 sm:mb-1 truncate">Inventory</p>
                        <p class="text-amber-100 text-xs sm:text-sm truncate">Stock Levels</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6 lg:mb-8">
            <div class="card-elevated bg-gradient-to-br from-brand-husk to-brand-teak p-4 sm:p-5 lg:p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-brand-off-yellow text-xs font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Today's Orders</p>
                        <p class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-1 sm:mb-2 leading-none">{{ $stats['today_orders'] }}</p>
                        <p class="text-brand-albescent-white text-xs sm:text-sm">Active transactions</p>
                    </div>
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 lg:p-4 flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-elevated bg-gradient-to-br from-emerald-600 to-teal-600 p-4 sm:p-5 lg:p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-emerald-100 text-xs font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Today's Revenue</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 sm:mb-2 leading-none break-words overflow-hidden">{{ format_money($stats['today_revenue']) }}</p>
                        <p class="text-emerald-200 text-xs sm:text-sm">Total earnings</p>
                    </div>
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 lg:p-4 flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-elevated bg-gradient-to-br from-amber-600 to-orange-600 p-4 sm:p-5 lg:p-6 text-white sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-amber-100 text-xs font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Low Stock Alerts</p>
                        <p class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-1 sm:mb-2 leading-none">{{ $stats['low_stock_count'] }}</p>
                        <p class="text-amber-200 text-xs sm:text-sm">Items need attention</p>
                    </div>
                    <div class="bg-white/20 rounded-lg sm:rounded-xl p-2 sm:p-3 lg:p-4 flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6 lg:mb-8">
            <!-- Revenue Chart -->
            <div class="card-elevated p-4 sm:p-5 lg:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-brand-husk to-brand-teak rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-slate-900 truncate">Revenue Trend (Last 7 Days)</h2>
                </div>
                <div class="h-48 sm:h-56 lg:h-64">
                    <canvas id="revenueChart" data-chart-data='@json($chartData)'></canvas>
                </div>
            </div>

            <!-- Orders Chart -->
            <div class="card-elevated p-4 sm:p-5 lg:p-6">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold text-slate-900 truncate">Orders Count (Last 7 Days)</h2>
                </div>
                <div class="h-48 sm:h-56 lg:h-64">
                    <canvas id="ordersChart" data-chart-data='@json($ordersChartData)'></canvas>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStockProducts->count() > 0)
        <div class="card-elevated border-l-4 border-red-500 p-4 sm:p-5 lg:p-6 mb-4 sm:mb-6 lg:mb-8">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h2 class="text-base sm:text-lg font-semibold text-slate-900 flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-red-600 to-rose-600 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <span class="truncate">Low Stock Products</span>
                </h2>
            </div>
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-slate-50 to-brand-old-lace/30">
                            <tr>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Product</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Stock</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Min</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($lowStockProducts as $inventory)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4">
                                    <div class="text-xs sm:text-sm font-bold text-slate-900 truncate max-w-[150px] sm:max-w-none">{{ $inventory->product->name }}</div>
                                    <div class="text-xs text-slate-500 font-medium truncate max-w-[150px] sm:max-w-none">{{ $inventory->product->sku }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-extrabold text-red-600">{{ $inventory->qty }}</span>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-slate-600 font-medium">{{ $inventory->min_threshold }}</td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap">
                                    <span class="px-2 sm:px-3 py-1 sm:py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-200">Low</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Orders -->
        <div class="card-elevated p-4 sm:p-5 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
                <h2 class="text-base sm:text-lg lg:text-xl font-semibold text-slate-900 flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-brand-husk to-brand-teak rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <span>Recent Orders</span>
                </h2>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:space-x-3">
                    <a href="{{ route('orders.index') }}" class="btn-secondary text-center text-sm sm:text-base px-4 sm:px-6 py-2 sm:py-3">
                        View All Orders
                    </a>
                    <a href="{{ route('pos.index') }}" class="btn-primary text-center text-sm sm:text-base px-4 sm:px-6 py-2 sm:py-3">
                        + New Order
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-slate-50 to-brand-old-lace/30">
                            <tr>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Reference</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Customer</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider hidden sm:table-cell">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4">
                                    <div class="text-xs sm:text-sm font-bold text-slate-900 truncate max-w-[100px] sm:max-w-none">{{ $order->reference }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4">
                                    <div class="text-xs sm:text-sm font-semibold text-slate-900 truncate max-w-[120px] sm:max-w-none">{{ $order->customer_name ?? 'Walk-in' }}</div>
                                    <div class="text-xs text-slate-500 font-medium truncate max-w-[120px] sm:max-w-none hidden sm:block">{{ $order->user->display_name ?? $order->user->name }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-extrabold text-slate-900">{{ format_money($order->total_amount) }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap">
                                    <span class="px-2 sm:px-3 py-1 sm:py-1.5 text-xs font-bold rounded-full {{ $order->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-slate-600 font-medium hidden sm:table-cell">
                                    {{ $order->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
