@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8 lg:mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-2 sm:mb-3 tracking-tight">
                    Create New User
                </h1>
                <p class="text-brand-akaroa font-medium text-sm sm:text-base">Add a new staff member to the system</p>
            </div>
            <a href="{{ route('admin.users') }}" class="bg-white text-brand-husk font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-brand-albescent-white hover:border-brand-husk flex items-center space-x-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-sm sm:text-base">Back to Users</span>
            </a>
        </div>

        <!-- Create User Form -->
        <div class="card-glass p-4 sm:p-6 lg:p-8 max-w-2xl">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 sm:space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Name -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-brand-husk mb-2">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="input-modern w-full"
                               placeholder="Enter full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display Name -->
                    <div class="sm:col-span-2">
                        <label for="display_name" class="block text-sm font-semibold text-brand-husk mb-2">Display Name</label>
                        <input type="text" id="display_name" name="display_name" value="{{ old('display_name') }}"
                               class="input-modern w-full"
                               placeholder="Enter display name (optional)">
                        <p class="mt-1 text-xs text-brand-akaroa">Leave empty to use full name</p>
                        @error('display_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-semibold text-brand-husk mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="input-modern w-full"
                               placeholder="Enter email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="sm:col-span-2">
                        <label for="phone" class="block text-sm font-semibold text-brand-husk mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="input-modern w-full"
                               placeholder="Enter phone number (optional)">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-brand-husk mb-2">Password *</label>
                        <input type="password" id="password" name="password" required
                               class="input-modern w-full"
                               placeholder="Enter password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-brand-husk mb-2">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="input-modern w-full"
                               placeholder="Confirm password">
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role_id" class="block text-sm font-semibold text-brand-husk mb-2">Role *</label>
                        <select id="role_id" name="role_id" required class="input-modern w-full">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Branch -->
                    <div>
                        <label for="branch_id" class="block text-sm font-semibold text-brand-husk mb-2">Branch</label>
                        <select id="branch_id" name="branch_id" class="input-modern w-full">
                            <option value="">No Branch</option>
                            @foreach($availableBranches as $availableBranch)
                                <option value="{{ $availableBranch->id }}" {{ old('branch_id', $branch?->id) == $availableBranch->id ? 'selected' : '' }}>
                                    {{ $availableBranch->name }} - {{ $availableBranch->business->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($branch)
                            <p class="mt-1 text-xs text-brand-akaroa">You can only assign users to your branch</p>
                        @endif
                        @error('branch_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4 sm:pt-6">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki hover:from-brand-teak hover:via-brand-indian-khaki hover:to-brand-akaroa text-white font-bold px-6 py-3 sm:py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create User</span>
                    </button>
                    <a href="{{ route('admin.users') }}" 
                       class="flex-1 bg-white text-brand-husk font-semibold px-6 py-3 sm:py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-brand-albescent-white hover:border-brand-husk flex items-center justify-center space-x-2">
                        <span>Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

