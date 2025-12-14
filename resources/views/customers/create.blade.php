@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Create Customer</h1>
            <p class="text-slate-600 font-medium text-lg">Add a new customer to your database</p>
        </div>

        <div class="card p-8">
            <form method="POST" action="{{ route('customers.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="input-modern w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="input-modern w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="input-modern w-full @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                        <textarea name="address" rows="2"
                                  class="input-modern w-full @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="input-modern w-full @error('city') border-red-500 @enderror">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">State</label>
                        <input type="text" name="state" value="{{ old('state') }}"
                               class="input-modern w-full @error('state') border-red-500 @enderror">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}"
                               class="input-modern w-full @error('country') border-red-500 @enderror">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                               class="input-modern w-full @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Branch (Super Admin only) -->
                    @if(auth()->user()->hasRole('super_admin'))
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Branch</label>
                        <select name="branch_id" class="input-modern w-full @error('branch_id') border-red-500 @enderror">
                            <option value="">Global (All Branches)</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="input-modern w-full @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm font-semibold text-slate-700">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex items-center space-x-4">
                    <button type="submit" class="btn-primary">Create Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

