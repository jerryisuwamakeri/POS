@extends('layouts.app')

@section('title', 'Branch Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Branch Management
                </h1>
                <p class="text-slate-600 font-medium">Manage all branches</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('branches.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    + New Branch
                </a>
                <a href="{{ route(dashboard_route()) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Dashboard
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <form method="GET" action="{{ route('branches.index') }}" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Filter by Business</label>
                    <select name="business_id" onchange="this.form.submit()"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                        <option value="">All Businesses</option>
                        @foreach($businesses as $business)
                            <option value="{{ $business->id }}" {{ request('business_id') == $business->id ? 'selected' : '' }}>
                                {{ $business->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Branches Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Business</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($branches as $branch)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $branch->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $branch->business->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 font-medium">{{ $branch->location ?? 'No location' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <span class="text-xs text-slate-600"><strong>{{ $branch->users_count }}</strong> users</span>
                                    <span class="text-xs text-slate-600"><strong>{{ $branch->orders_count }}</strong> orders</span>
                                    <span class="text-xs text-slate-600"><strong>{{ $branch->products_count }}</strong> products</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('branches.show', $branch) }}" class="text-blue-600 hover:text-blue-700 hover:underline">View</a>
                                <a href="{{ route('branches.edit', $branch) }}" class="text-indigo-600 hover:text-indigo-700 hover:underline">Edit</a>
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will delete the branch permanently.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No branches found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($branches->hasPages())
            <div class="mt-6">
                {{ $branches->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

