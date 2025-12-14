@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6 max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                Edit Business
            </h1>
            <a href="{{ route('businesses.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">← Back to Businesses</a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-8">
            <form method="POST" action="{{ route('businesses.update', $business) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Business Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name', $business->name) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">{{ old('address', $business->address) }}</textarea>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $business->email) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $business->phone) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>

                    <div>
                        <label for="subscription_status" class="block text-sm font-semibold text-slate-700 mb-2">Subscription Status *</label>
                        <select id="subscription_status" name="subscription_status" required
                                class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                            <option value="active" {{ old('subscription_status', $business->subscription_status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="trial" {{ old('subscription_status', $business->subscription_status) === 'trial' ? 'selected' : '' }}>Trial</option>
                            <option value="inactive" {{ old('subscription_status', $business->subscription_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Update Business
                    </button>
                    <a href="{{ route('businesses.index') }}" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

