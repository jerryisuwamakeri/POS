@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8">
        <div class="mb-10 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Customers</h1>
                <p class="text-slate-600 font-medium text-lg">Manage your customer database</p>
            </div>
            <div class="flex items-center space-x-3 flex-wrap">
                <a href="{{ route('customers.create') }}" class="btn-primary">+ New Customer</a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card p-6 mb-6">
            <form method="GET" action="{{ route('customers.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Name, email, or phone..." 
                           class="input-modern w-full">
                </div>
                <div class="min-w-[150px]">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="active" class="input-modern w-full">
                        <option value="">All</option>
                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn-secondary">Filter</button>
                @if(request()->hasAny(['search', 'active']))
                    <a href="{{ route('customers.index') }}" class="btn-secondary">Clear</a>
                @endif
            </form>
        </div>

        <!-- Customers Table -->
        <div class="card p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-gradient-to-r from-slate-50 via-blue-50/30 to-slate-50 border-b-2 border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Branch</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-slate-50/50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-semibold text-slate-900">{{ $customer->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-600">
                                @if($customer->email)
                                    <div>{{ $customer->email }}</div>
                                @endif
                                @if($customer->phone)
                                    <div>{{ $customer->phone }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-600">
                                @if($customer->city || $customer->state)
                                    <div>{{ $customer->city }}{{ $customer->city && $customer->state ? ', ' : '' }}{{ $customer->state }}</div>
                                @endif
                                @if($customer->address)
                                    <div class="text-xs text-slate-500 truncate max-w-xs">{{ $customer->address }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-600">
                                {{ $customer->branch ? $customer->branch->name : 'Global' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($customer->active)
                                <span class="badge bg-green-100 text-green-700 border-green-200">Active</span>
                            @else
                                <span class="badge bg-slate-100 text-slate-700 border-slate-200">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-slate-400 font-medium">No customers found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($customers->hasPages())
            <div class="mt-6">
                {{ $customers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

