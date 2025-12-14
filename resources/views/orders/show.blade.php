@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Order Details
                </h1>
                <p class="text-slate-600 font-medium">Reference: {{ $order->reference }}</p>
            </div>
            <div class="flex items-center space-x-3">
                @if($order->receipt)
                <a href="{{ route('receipts.download', $order->receipt) }}" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all font-bold shadow-lg hover:shadow-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Receipt
                </a>
                @endif
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl hover:from-red-700 hover:to-rose-700 transition-all font-bold shadow-lg hover:shadow-xl flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Order
                    </button>
                </form>
                @endif
                <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200">
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-slate-500">Quantity: {{ $item->qty }} × {{ format_money($item->unit_price) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-extrabold text-lg text-slate-900">{{ format_money($item->qty * $item->unit_price) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                @if($order->payments->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Payment History</h2>
                    <div class="space-y-3">
                        @foreach($order->payments as $payment)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                            <div>
                                <p class="font-semibold text-slate-900">{{ format_money($payment->amount) }}</p>
                                <p class="text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $payment->method)) }} - {{ ucfirst($payment->status) }}</p>
                            </div>
                            <p class="text-sm text-slate-600">{{ $payment->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Order Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 font-medium">Subtotal</span>
                            <span class="font-bold text-slate-900">{{ format_money($order->total_amount) }}</span>
                        </div>
                        <div class="border-t-2 border-slate-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-slate-700">Total</span>
                                <span class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ format_money($order->total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                    <h2 class="text-xl font-bold text-slate-800 mb-4">Order Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Customer</p>
                            <p class="font-semibold text-slate-900">{{ $order->customer_name ?? 'Walk-in Customer' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Cashier</p>
                            <p class="font-semibold text-slate-900">{{ $order->user->display_name ?? $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Branch</p>
                            <p class="font-semibold text-slate-900">{{ $order->branch->name }}</p>
                            <p class="text-sm text-slate-500">{{ $order->branch->business->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Payment Method</p>
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200 capitalize">
                                {{ str_replace('_', ' ', $order->payment_method) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Status</p>
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $order->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Date & Time</p>
                            <p class="font-semibold text-slate-900">{{ $order->created_at->format('F d, Y') }}</p>
                            <p class="text-sm text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

