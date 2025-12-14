@extends('layouts.app')

@section('title', 'Accounting Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-3">
                Accounting Dashboard
            </h1>
            <p class="text-slate-600 font-medium flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $branch->name }} - {{ $branch->business->name }}</span>
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <div class="group bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-emerald-400/20 hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-emerald-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Today's Revenue</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['today_revenue']) }}</p>
                        <p class="text-emerald-200 text-[10px] sm:text-xs font-medium">Daily earnings</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-gradient-to-br from-brand-husk via-brand-teak to-brand-indian-khaki rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-blue-400/20 hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-blue-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Month Revenue</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['month_revenue']) }}</p>
                        <p class="text-blue-200 text-[10px] sm:text-xs font-medium">Monthly total</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-rose-400/20 hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-rose-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Month Expenses</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['month_expenses']) }}</p>
                        <p class="text-rose-200 text-[10px] sm:text-xs font-medium">Monthly costs</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-gradient-to-br {{ $stats['net_profit'] >= 0 ? 'from-purple-500 via-indigo-600 to-purple-600' : 'from-orange-500 via-red-600 to-orange-600' }} rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border {{ $stats['net_profit'] >= 0 ? 'border-purple-400/20' : 'border-orange-400/20' }} hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-white/90 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Net Profit</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['net_profit']) }}</p>
                        <p class="text-white/80 text-[10px] sm:text-xs font-medium">Profit/Loss</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue vs Expenses Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 hover:shadow-2xl transition-shadow">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Revenue vs Expenses (Last 30 Days)</h2>
                </div>
                <div class="h-80">
                    <canvas id="revenueExpensesChart" 
                            data-revenue-data='@json($revenueChartData)'
                            data-expenses-data='@json($expensesChartData)'></canvas>
                </div>
            </div>

            <!-- Payment Methods Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 hover:shadow-2xl transition-shadow">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-husk to-brand-teak rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Payment Methods Breakdown</h2>
                </div>
                <div class="h-80">
                    <canvas id="paymentMethodsChart" data-chart-data='@json($paymentMethodsData)'></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payments -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Recent Payments</h2>
                </div>
                <div class="overflow-x-auto max-h-96 overflow-y-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Order Ref</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Method</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($recentPayments as $payment)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-slate-900">
                                    {{ $payment->order->reference ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-extrabold text-slate-900">
                                    {{ format_money($payment->amount) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                        {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    {{ $payment->created_at->format('M d, H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Recent Expenses</h2>
                </div>
                <div class="overflow-x-auto max-h-96 overflow-y-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-slate-50 to-red-50/30 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($recentExpenses as $expense)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-slate-900">
                                    {{ $expense->title }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-extrabold text-red-600">
                                    {{ format_money($expense->amount) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $expense->category ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    {{ $expense->created_at->format('M d, H:i') }}
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
