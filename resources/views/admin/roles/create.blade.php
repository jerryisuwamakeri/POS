@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8 max-w-4xl mx-auto">
        <div class="mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gradient mb-4 tracking-tight">
                Create New Role
            </h1>
            <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline text-lg">← Back to Roles</a>
        </div>

        <div class="card p-10">
            <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-8">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-3">Role Name *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}"
                           placeholder="e.g., manager, supervisor"
                           class="input-modern">
                    <p class="mt-2 text-xs text-slate-500">Use lowercase with underscores (e.g., store_manager)</p>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-4">Assign Permissions</label>
                    <div class="border-2 border-slate-200 rounded-xl p-6 max-h-96 overflow-y-auto custom-scrollbar bg-slate-50/50">
                        <div class="space-y-3">
                            @php
                                $grouped = $permissions->groupBy(function ($permission) {
                                    $parts = explode(' ', $permission->name);
                                    return $parts[0];
                                });
                            @endphp
                            @foreach($grouped as $category => $perms)
                            <div class="mb-6">
                                <h4 class="font-bold text-slate-800 mb-3 capitalize">{{ $category }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($perms as $permission)
                                    <label class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer border border-slate-200">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
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

                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 btn-primary py-4">
                        Create Role
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="flex-1 btn-secondary py-4 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

