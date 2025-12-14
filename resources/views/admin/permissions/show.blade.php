@extends('layouts.app')

@section('title', 'Permission Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Permission: {{ $permission->name }}
                </h1>
                <p class="text-slate-600 font-medium">Assigned to {{ $permission->roles_count }} {{ Str::plural('role', $permission->roles_count) }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.permissions.edit', $permission) }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Edit Permission
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Back
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Roles with this Permission</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($permission->roles as $role)
                <div class="p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 capitalize">{{ str_replace('_', ' ', $role->name) }}</p>
                            <p class="text-sm text-slate-500">{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}</p>
                        </div>
                        <a href="{{ route('admin.roles.show', $role) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm hover:underline">
                            View →
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 font-medium">No roles assigned this permission</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

