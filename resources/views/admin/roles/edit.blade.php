@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6 max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                Edit Role: {{ str_replace('_', ' ', $role->name) }}
            </h1>
            <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">← Back to Roles</a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-8">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Role Name *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $role->name) }}"
                           class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-4">Assign Permissions</label>
                    <div class="border-2 border-slate-200 rounded-xl p-4 max-h-96 overflow-y-auto">
                        <div class="space-y-3">
                            @php
                                $grouped = $permissions->groupBy(function ($permission) {
                                    $parts = explode(' ', $permission->name);
                                    return $parts[0];
                                });
                                $rolePermissionIds = $role->permissions->pluck('id')->toArray();
                            @endphp
                            @foreach($grouped as $category => $perms)
                            <div class="mb-6">
                                <h4 class="font-bold text-slate-800 mb-3 capitalize">{{ $category }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($perms as $permission)
                                    <label class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer border border-slate-200">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                               {{ in_array($permission->id, $rolePermissionIds) ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <span class="text-sm font-medium text-slate-700">{{ $permission->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Update Role
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

