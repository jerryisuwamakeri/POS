@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">
                    Roles Management
                </h1>
                <p class="text-slate-600 font-medium text-lg">Manage user roles and their permissions</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.permissions.index') }}" class="btn-primary bg-gradient-to-r from-purple-600 to-indigo-600 shadow-purple-500/25 hover:shadow-purple-500/40">
                    Manage Permissions
                </a>
                <a href="{{ route('admin.roles.create') }}" class="btn-primary">
                    + New Role
                </a>
                <a href="{{ route('admin.users') }}" class="btn-secondary">
                    ← Users
                </a>
            </div>
        </div>

        <!-- Roles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($roles as $role)
            <div class="card p-6 hover:shadow-2xl transition-all duration-300 animate-scale-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 capitalize">{{ str_replace('_', ' ', $role->name) }}</h3>
                        <p class="text-sm text-slate-500 font-medium mt-1">
                            {{ $role->users_count }} {{ Str::plural('user', $role->users_count) }} • {{ $role->permissions_count }} {{ Str::plural('permission', $role->permissions_count) }}
                        </p>
                    </div>
                    @php
                        $roleColors = [
                            'super_admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                            'admin' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'sales' => 'bg-green-100 text-green-700 border-green-200',
                            'accounting' => 'bg-amber-100 text-amber-700 border-amber-200',
                        ];
                        $colorClass = $roleColors[$role->name] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                    @endphp
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $colorClass }} border">
                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                    </span>
                </div>

                <div class="mb-4">
                    <p class="text-sm font-semibold text-slate-700 mb-2">Permissions:</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($role->permissions->take(5) as $permission)
                        <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-lg border border-slate-200">
                            {{ $permission->name }}
                        </span>
                        @empty
                        <span class="text-xs text-slate-400 italic">No permissions assigned</span>
                        @endforelse
                        @if($role->permissions->count() > 5)
                        <span class="px-2 py-1 text-xs font-medium text-slate-500">
                            +{{ $role->permissions->count() - 5 }} more
                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-2 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.roles.show', $role) }}" class="flex-1 px-4 py-2 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-all font-semibold text-center text-sm">
                        View
                    </a>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="flex-1 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl hover:bg-indigo-100 transition-all font-semibold text-center text-sm">
                        Edit
                    </a>
                    @if(!in_array($role->name, ['super_admin', 'admin', 'sales', 'accounting']))
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-all font-semibold text-sm">
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="card p-12 text-center">
                    <p class="text-slate-400 font-medium text-lg mb-4">No roles found</p>
                    <a href="{{ route('admin.roles.create') }}" class="btn-primary inline-block">
                        Create First Role
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

