@extends('layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-3">
                Sales Dashboard
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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <div class="group bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-5 lg:p-6 text-white transform hover:scale-[1.02] transition-all duration-300 border border-emerald-400/20 hover:shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-emerald-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Today's Sales</p>
                        <p class="text-lg sm:text-xl lg:text-2xl font-bold mb-1 break-words overflow-hidden">{{ format_money($stats['today_sales']) }}</p>
                        <p class="text-emerald-200 text-[10px] sm:text-xs font-medium">Total revenue</p>
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
                        <p class="text-blue-100 text-xs sm:text-sm font-semibold mb-1 sm:mb-2 uppercase tracking-wide">Today's Orders</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1 break-words overflow-hidden">{{ $stats['today_orders'] }}</p>
                        <p class="text-blue-200 text-[10px] sm:text-xs font-medium">Transactions</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 lg:p-4 group-hover:bg-white/30 transition-all flex-shrink-0 ml-2 sm:ml-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shift Status Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span>Shift Status</span>
            </h2>
            @if($activeShift)
                <div class="bg-gradient-to-r from-emerald-50 via-green-50 to-teal-50 border-2 border-emerald-300 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-emerald-800 font-extrabold text-xl mb-2 flex items-center space-x-2">
                                <span>✅</span>
                                <span>You are currently clocked in</span>
                            </p>
                            <p class="text-sm text-emerald-700 font-medium mb-1">Started: {{ $activeShift->clock_in_at->format('Y-m-d H:i:s') }}</p>
                            <p class="text-sm text-emerald-700 font-medium">
                                Duration: {{ $activeShift->clock_in_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('api.shifts.clock-out') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-rose-600 text-white px-6 py-4 rounded-xl hover:from-red-700 hover:to-rose-700 transition-all font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-[1.02]">
                            🕐 Clock Out
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 border-2 border-amber-300 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-amber-800 font-extrabold text-xl mb-2 flex items-center space-x-2">
                                <span>⏸️</span>
                                <span>You are not clocked in</span>
                            </p>
                            <p class="text-sm text-amber-700 font-medium">Click the button below to start your shift</p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl p-5 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('api.shifts.clock-in') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-green-600 text-white px-6 py-4 rounded-xl hover:from-emerald-700 hover:to-green-700 transition-all font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-[1.02]">
                            🕐 Clock In
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span>Quick Actions</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('pos.index') }}" class="bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki text-white px-8 py-6 rounded-xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all transform hover:scale-[1.02] font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center border border-blue-500/20">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Open POS Terminal
                </a>
                <a href="{{ route('shifts.index') }}" class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 text-white px-8 py-6 rounded-xl hover:from-purple-700 hover:via-indigo-700 hover:to-blue-700 transition-all transform hover:scale-[1.02] font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center border border-purple-500/20">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    View My Shifts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
