@extends('layouts.app')

@section('title', 'Business Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Business Management
                </h1>
                <p class="text-slate-600 font-medium">Manage all businesses in the system</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('businesses.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    + New Business
                </a>
                <a href="{{ route(dashboard_route()) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Dashboard
                </a>
            </div>
        </div>

        <!-- Businesses Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Business</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Branches</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
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
                                @elseif($business->subscription_status === 'trial')
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                        Trial
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('businesses.show', $business) }}" class="text-blue-600 hover:text-blue-700 hover:underline">View</a>
                                <a href="{{ route('businesses.edit', $business) }}" class="text-indigo-600 hover:text-indigo-700 hover:underline">Edit</a>
                                <form action="{{ route('businesses.destroy', $business) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this business?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No businesses found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($businesses->hasPages())
            <div class="mt-6">
                {{ $businesses->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

