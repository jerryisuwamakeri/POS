@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Role: {{ str_replace('_', ' ', $role->name) }}
                </h1>
                <p class="text-slate-600 font-medium">{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }} • {{ $role->permissions_count }} {{ Str::plural('permission', $role->permissions_count) }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.roles.edit', $role) }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Edit Role
                </a>
                <a href="{{ route('admin.roles.index') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Permissions -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Assigned Permissions</h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($role->permissions as $permission)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200">
                        <span class="font-semibold text-slate-900">{{ $permission->name }}</span>
                    </div>
                    @empty
                    <p class="text-slate-400 text-center py-8">No permissions assigned</p>
                    @endforelse
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Users with this Role</h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($role->users as $user)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $user->display_name ?? $user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-400 text-center py-8">No users assigned</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

