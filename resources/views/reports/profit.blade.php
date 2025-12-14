@extends('layouts.app')

@section('title', 'Profit Analysis')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Profit Analysis
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
            <form method="GET" action="{{ route('reports.profit') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

        <!-- Profit Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-blue-100 text-sm font-semibold mb-2 uppercase tracking-wide">Total Revenue</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ format_money($stats['revenue']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-amber-500 via-orange-600 to-red-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-amber-100 text-sm font-semibold mb-2 uppercase tracking-wide">Product Costs</p>
                <p class="text-3xl font-extrabold mb-1">{{ format_money($stats['product_costs']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-rose-100 text-sm font-semibold mb-2 uppercase tracking-wide">Expenses</p>
                <p class="text-3xl font-extrabold mb-1">{{ format_money($stats['expenses']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-emerald-100 text-sm font-semibold mb-2 uppercase tracking-wide">Net Profit</p>
                <p class="text-3xl font-extrabold mb-1">{{ format_money($stats['net_profit']) }}</p>
                <p class="text-emerald-200 text-xs font-medium">{{ number_format($stats['net_margin'], 1) }}% margin</p>
            </div>
        </div>

        <!-- Profit Margins -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Profit Breakdown</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-blue-50 rounded-xl">
                        <span class="font-semibold text-slate-700">Gross Profit</span>
                        <span class="text-2xl font-extrabold text-blue-600">{{ format_money($stats['gross_profit']) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-emerald-50 rounded-xl">
                        <span class="font-semibold text-slate-700">Net Profit</span>
                        <span class="text-2xl font-extrabold text-emerald-600">{{ format_money($stats['net_profit']) }}</span>
                    </div>
                    <div class="border-t-2 border-slate-200 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Gross Margin</span>
                            <span class="font-bold text-slate-900">{{ number_format($stats['gross_margin'], 2) }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Net Margin</span>
                            <span class="font-bold text-slate-900">{{ number_format($stats['net_margin'], 2) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Profit Trend -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Daily Profit Trend</h2>
                <div class="h-64">
                    <canvas id="profitChart" data-chart-data='@json($dailyProfit)'></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profitCtx = document.getElementById('profitChart');
    if (profitCtx) {
        const profitData = JSON.parse(profitCtx.dataset.chartData);
        new Chart(profitCtx, {
            type: 'line',
            data: {
                labels: profitData.map(d => new Date(d.date).toLocaleDateString()),
                datasets: [
                    {
                        label: 'Revenue',
                        data: profitData.map(d => d.revenue / 100),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Profit',
                        data: profitData.map(d => d.profit / 100),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

