@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-6xl mx-auto">
        <div class="mb-10 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">{{ $customer->name }}</h1>
                <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline text-lg flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Customers
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('customers.edit', $customer) }}" class="btn-primary">Edit Customer</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Name</label>
                            <p class="text-lg font-semibold text-slate-900">{{ $customer->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Status</label>
                            @if($customer->active)
                                <span class="badge bg-green-100 text-green-700 border-green-200">Active</span>
                            @else
                                <span class="badge bg-slate-100 text-slate-700 border-slate-200">Inactive</span>
                            @endif
                        </div>
                        @if($customer->email)
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Email</label>
                            <p class="text-lg text-slate-900">{{ $customer->email }}</p>
                        </div>
                        @endif
                        @if($customer->phone)
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Phone</label>
                            <p class="text-lg text-slate-900">{{ $customer->phone }}</p>
                        </div>
                        @endif
                        @if($customer->branch)
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Branch</label>
                            <p class="text-lg text-slate-900">{{ $customer->branch->name }}</p>
                        </div>
                        @endif
                        @if($customer->full_address)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Address</label>
                            <p class="text-lg text-slate-900">{{ $customer->full_address }}</p>
                        </div>
                        @endif
                        @if($customer->notes)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Notes</label>
                            <p class="text-lg text-slate-900 whitespace-pre-wrap">{{ $customer->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card p-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Recent Orders</h2>
                    @if($customer->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Reference</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Amount</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach($customer->orders as $order)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 text-sm text-slate-900">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-900">{{ $order->reference }}</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ format_money($order->total_amount) }}</td>
                                        <td class="px-4 py-3">
                                            @if($order->status === 'paid')
                                                <span class="badge bg-green-100 text-green-700 border-green-200">Paid</span>
                                            @else
                                                <span class="badge bg-yellow-100 text-yellow-700 border-yellow-200">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-slate-400 text-center py-8">No orders found</p>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="space-y-6">
                <div class="card p-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Statistics</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Total Orders</label>
                            <p class="text-3xl font-extrabold text-slate-900">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Total Spent</label>
                            <p class="text-3xl font-extrabold text-blue-600">{{ format_money($stats['total_spent']) }}</p>
                        </div>
                        @if($stats['last_order'])
                        <div>
                            <label class="block text-sm font-semibold text-slate-500 mb-1">Last Order</label>
                            <p class="text-lg text-slate-900">{{ $stats['last_order']->created_at->format('M d, Y') }}</p>
                            <p class="text-sm text-slate-600">{{ format_money($stats['last_order']->total_amount) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

