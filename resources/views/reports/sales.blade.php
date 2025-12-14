@extends('layouts.app')

@section('title', 'Sales Reports & Analytics')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Sales Reports & Analytics
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

        <!-- Date Filter -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <form method="GET" action="{{ route('reports.sales') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-blue-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Revenue</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ format_money($stats['total_revenue']) }}</p>
                <p class="text-blue-200 text-xs font-medium">All sales</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-emerald-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Orders</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['total_orders'] }}</p>
                <p class="text-emerald-200 text-xs font-medium">Transactions</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-purple-100 text-sm font-semibold mb-2 uppercase tracking-wide">Avg Order Value</p>
                <p class="text-4xl font-extrabold mb-1">{{ format_money($stats['average_order_value']) }}</p>
                <p class="text-purple-200 text-xs font-medium">Per transaction</p>
            </div>
            <div class="bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-rose-100 text-sm font-semibold mb-2 uppercase tracking-wide">Net Profit</p>
                <p class="text-4xl font-extrabold mb-1">{{ format_money($stats['net_profit']) }}</p>
                <p class="text-rose-200 text-xs font-medium">{{ number_format($stats['profit_margin'], 1) }}% margin</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Trend -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Revenue Trend</h2>
                <div class="h-64">
                    <canvas id="revenueChart" data-chart-data='@json($dailyRevenue)'></canvas>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Payment Methods</h2>
                <div class="h-64">
                    <canvas id="paymentMethodsChart" data-chart-data='@json($paymentMethods)'></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products & Hourly Sales -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Products -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Top Selling Products</h2>
                <div class="space-y-3">
                    @forelse($topProducts as $item)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200">
                        <div class="flex-1">
                            <p class="font-bold text-slate-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-slate-500">Qty: {{ $item->total_qty }} | Revenue: {{ format_money($item->total_revenue) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-400 text-center py-8">No products sold</p>
                    @endforelse
                </div>
            </div>

            <!-- Hourly Sales Pattern -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Hourly Sales Pattern</h2>
                <div class="h-64">
                    <canvas id="hourlySalesChart" data-chart-data='@json($hourlySales)'></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = JSON.parse(revenueCtx.dataset.chartData);
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(d => new Date(d.date).toLocaleDateString()),
                datasets: [{
                    label: 'Revenue',
                    data: revenueData.map(d => d.revenue / 100),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    }

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentMethodsChart');
    if (paymentCtx) {
        const paymentData = JSON.parse(paymentCtx.dataset.chartData);
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: paymentData.map(d => d.payment_method.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: paymentData.map(d => d.total / 100),
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(168, 85, 247)',
                        'rgb(245, 158, 11)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Hourly Sales Chart
    const hourlyCtx = document.getElementById('hourlySalesChart');
    if (hourlyCtx) {
        const hourlyData = JSON.parse(hourlyCtx.dataset.chartData);
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hourlyData.map(d => d.hour + ':00'),
                datasets: [{
                    label: 'Revenue',
                    data: hourlyData.map(d => d.revenue / 100),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection

