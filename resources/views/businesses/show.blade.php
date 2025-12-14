@extends('layouts.app')

@section('title', $business->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    {{ $business->name }}
                </h1>
                <p class="text-slate-600 font-medium">{{ $business->address ?? 'No address' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('businesses.edit', $business) }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Edit Business
                </a>
                <a href="{{ route('businesses.index') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-blue-100 text-sm font-semibold mb-2 uppercase tracking-wide">Branches</p>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ $stats['total_branches'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-emerald-100 text-sm font-semibold mb-2 uppercase tracking-wide">Users</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-purple-100 text-sm font-semibold mb-2 uppercase tracking-wide">Orders</p>
                <p class="text-4xl font-extrabold mb-1">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 rounded-2xl shadow-xl p-6 text-white">
                <p class="text-rose-100 text-sm font-semibold mb-2 uppercase tracking-wide">Revenue</p>
                <p class="text-3xl font-extrabold mb-1">{{ format_money($stats['total_revenue']) }}</p>
            </div>
        </div>

        <!-- Business Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Business Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Email</p>
                        <p class="font-semibold text-slate-900">{{ $business->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Phone</p>
                        <p class="font-semibold text-slate-900">{{ $business->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Subscription Status</p>
                        @if($business->subscription_status === 'active')
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                Active
                            </span>
                        @elseif($business->subscription_status === 'trial')
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                Trial
                            </span>
                        @else
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('branches.create') }}?business_id={{ $business->id }}" class="block w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-semibold text-center shadow-lg hover:shadow-xl">
                        + Add Branch
                    </a>
                    <a href="{{ route('branches.index', ['business_id' => $business->id]) }}" class="block w-full px-4 py-3 bg-white text-slate-700 rounded-xl hover:bg-slate-50 transition-all font-semibold text-center border border-slate-200">
                        View Branches
                    </a>
                </div>
            </div>
        </div>

        <!-- Branches List -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Branches</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($business->branches as $branch)
                <div class="p-5 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200 hover:border-blue-300 transition-all">
                    <h3 class="font-bold text-slate-900 mb-2">{{ $branch->name }}</h3>
                    <p class="text-sm text-slate-500 mb-3">{{ $branch->location ?? 'No location' }}</p>
                    <a href="{{ route('branches.show', $branch) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm hover:underline">
                        View Details →
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 font-medium">No branches yet</p>
                    <a href="{{ route('branches.create') }}?business_id={{ $business->id }}" class="mt-4 inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-semibold">
                        Create First Branch
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

