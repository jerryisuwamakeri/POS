@extends('layouts.app')

@section('title', 'Expenses Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Expenses Management
                </h1>
                <p class="text-slate-600 font-medium flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $branch->name }} - {{ $branch->business->name }}</span>
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="document.getElementById('expense-modal').classList.remove('hidden')" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    + New Expense
                </button>
                <a href="{{ route(dashboard_route()) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Dashboard
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-8">
            <form method="GET" action="{{ route('accounting.expenses') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                    <select name="category" class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                        <option value="">All Categories</option>
                        <option value="rent" {{ request('category') === 'rent' ? 'selected' : '' }}>Rent</option>
                        <option value="utilities" {{ request('category') === 'utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="supplies" {{ request('category') === 'supplies' ? 'selected' : '' }}>Supplies</option>
                        <option value="salaries" {{ request('category') === 'salaries' ? 'selected' : '' }}>Salaries</option>
                        <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Expenses Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Recorded By</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($expenses as $expense)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $expense->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200 capitalize">
                                    {{ $expense->category ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-extrabold text-red-600">{{ format_money($expense->amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $expense->user->display_name ?? $expense->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ $expense->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No expenses found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($expenses->hasPages())
            <div class="mt-6">
                {{ $expenses->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Expense Modal -->
<div id="expense-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-2xl w-full mx-4 transform transition-all shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-3xl font-extrabold text-slate-900">Record New Expense</h3>
            <button onclick="document.getElementById('expense-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('accounting.expenses.create') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Expense Title *</label>
                <input type="text" id="title" name="title" required
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="amount" class="block text-sm font-semibold text-slate-700 mb-2">Amount (₦) *</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                </div>
                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                    <select id="category" name="category"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                        <option value="">Select Category</option>
                        <option value="rent">Rent</option>
                        <option value="utilities">Utilities</option>
                        <option value="supplies">Supplies</option>
                        <option value="salaries">Salaries</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="receipt" class="block text-sm font-semibold text-slate-700 mb-2">Receipt (Optional)</label>
                <input type="file" id="receipt" name="receipt" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                <p class="text-xs text-slate-500 mt-2">Accepted: PDF, JPG, PNG (Max 2MB)</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Record Expense
                </button>
                <button type="button" onclick="document.getElementById('expense-modal').classList.add('hidden')" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

