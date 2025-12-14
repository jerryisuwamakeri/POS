@extends('layouts.app')

@section('title', 'Permissions Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Permissions Management
                </h1>
                <p class="text-slate-600 font-medium">Manage system permissions</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.permissions.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    + New Permission
                </a>
                <a href="{{ route('admin.roles.index') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Manage Roles
                </a>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold border border-slate-200 hover:border-slate-300">
                    ← Users
                </a>
            </div>
        </div>

        <!-- Permissions by Category -->
        @foreach($grouped as $category => $perms)
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-6 mb-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 capitalize">{{ $category }} Permissions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($perms as $permission)
                <div class="p-4 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-xl border border-slate-200 hover:border-blue-300 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-slate-900">{{ $permission->name }}</h3>
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                            {{ $permission->roles_count }} {{ Str::plural('role', $permission->roles_count) }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2 mt-3">
                        <a href="{{ route('admin.permissions.show', $permission) }}" class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-all font-semibold text-center text-sm">
                            View
                        </a>
                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="flex-1 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-all font-semibold text-center text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will remove the permission from all roles.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all font-semibold text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

