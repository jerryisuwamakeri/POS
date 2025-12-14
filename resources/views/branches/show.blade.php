@extends('layouts.app')

@section('title', $branch->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    {{ $branch->name }}
                </h1>
                <p class="text-slate-600 font-medium">{{ $branch->business->name }} • {{ $branch->location ?? 'No location' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('branches.edit', $branch) }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Edit Branch
                </a>
                <a href="{{ route('branches.index') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-blue-100 text-sm font-semibold mb-2 uppercase tracking-wide">Users</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-emerald-100 text-sm font-semibold mb-2 uppercase tracking-wide">Products</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-purple-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Revenue</p>
                <p class="text-3xl font-extrabold mb-1">{{ format_money($stats['total_revenue']) }}</p>
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Today's Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
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
                <h3 class="text-xl font-bold text-slate-800 mb-4">Branch Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Business</p>
                        <p class="font-semibold text-slate-900">{{ $branch->business->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Location</p>
                        <p class="font-semibold text-slate-900">{{ $branch->location ?? 'Not specified' }}</p>
                    </div>
                    @if($branch->geo_lat && $branch->geo_lng)
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Coordinates</p>
                        <p class="font-semibold text-slate-900">{{ $branch->geo_lat }}, {{ $branch->geo_lng }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($branch->orders->take(10) as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $order->reference }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $order->customer_name ?? 'Walk-in' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-extrabold text-slate-900">{{ format_money($order->total_amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No orders yet</div>
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

