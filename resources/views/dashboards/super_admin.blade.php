@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-3">
                Super Admin Dashboard
            </h1>
            <p class="text-slate-600 font-medium">System Overview & Management</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <div class="group bg-gradient-to-br from-brand-husk via-brand-teak to-brand-indian-khaki rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-blue-400/20 hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-blue-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Total Businesses</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 break-words overflow-hidden">{{ $stats['total_businesses'] }}</p>
                        <p class="text-blue-200 text-[10px] sm:text-xs font-medium">Active businesses</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-emerald-400/20 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-emerald-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Total Branches</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 break-words overflow-hidden">{{ $stats['total_branches'] }}</p>
                        <p class="text-emerald-200 text-[10px] sm:text-xs font-medium">Branch locations</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-purple-400/20 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-purple-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Total Users</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 break-words overflow-hidden">{{ $stats['total_users'] }}</p>
                        <p class="text-purple-200 text-[10px] sm:text-xs font-medium">System users</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-rose-400/20 hover:shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-rose-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Total Revenue</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['total_revenue']) }}</p>
                        <p class="text-rose-200 text-[10px] sm:text-xs font-medium">All-time revenue</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Today's Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-brand-off-yellow to-brand-old-lace rounded-xl">
                        <span class="text-slate-700 font-semibold">Orders</span>
                        <span class="text-2xl font-extrabold text-blue-600">{{ $stats['today_orders'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                        <span class="text-slate-700 font-semibold">Revenue</span>
                        <span class="text-2xl font-extrabold text-emerald-600">{{ format_money($stats['today_revenue']) }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Top Performing Branches</h3>
                <div class="space-y-3">
                    @forelse($topBranches as $branch)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div>
                            <p class="font-bold text-slate-900">{{ $branch->name }}</p>
                            <p class="text-sm text-slate-500">{{ $branch->business->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-emerald-600">{{ format_money($branch->total_revenue ?? 0) }}</p>
                            <p class="text-xs text-slate-500">{{ $branch->orders_count }} orders</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-400 text-center py-4">No branches yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Businesses Management -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-800 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-husk to-brand-teak rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span>Businesses</span>
                </h2>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Manage Users
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Business</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Branches</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($businesses as $business)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $business->name }}</div>
                                <div class="text-sm text-slate-500 font-medium">{{ $business->address ?? 'No address' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                    {{ $business->branches_count }} {{ Str::plural('branch', $business->branches_count) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 font-medium">{{ $business->email ?? 'N/A' }}</div>
                                <div class="text-sm text-slate-500">{{ $business->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($business->subscription_status === 'active')
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No businesses found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span>Recent Orders</span>
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Business/Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $order->reference }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $order->branch->business->name ?? 'N/A' }}</div>
                                <div class="text-sm text-slate-500 font-medium">{{ $order->branch->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $order->customer_name ?? 'Walk-in' }}</div>
                                <div class="text-sm text-slate-500 font-medium">{{ $order->user->display_name ?? $order->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-extrabold text-slate-900">{{ format_money($order->total_amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $order->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No orders found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
