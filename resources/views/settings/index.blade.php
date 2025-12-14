@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">Settings</h1>
            <p class="text-slate-600 font-medium text-lg">Manage your account and application settings</p>
        </div>

        <div class="space-y-6">
            <!-- Profile Settings -->
            <div class="card p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Profile Settings</h2>
                <form method="POST" action="{{ route('settings.update-profile') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Full Name *</label>
                            <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="input-modern">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Display Name</label>
                            <input type="text" name="display_name" value="{{ old('display_name', $user->display_name) }}" class="input-modern">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Email *</label>
                            <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="input-modern">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-modern">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Update Profile</button>
                </form>
            </div>

            <!-- Password Settings -->
            <div class="card p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Change Password</h2>
                <form method="POST" action="{{ route('settings.update-password') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Current Password *</label>
                        <input type="password" name="current_password" required class="input-modern">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">New Password *</label>
                            <input type="password" name="password" required class="input-modern">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Confirm Password *</label>
                            <input type="password" name="password_confirmation" required class="input-modern">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Update Password</button>
                </form>
            </div>

            <!-- Branch Info -->
            @if($branch)
            <div class="card p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Branch Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Branch Name</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $branch->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Business</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $branch->business->name }}</p>
                    </div>
                    @if($branch->location)
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Location</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $branch->location }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

