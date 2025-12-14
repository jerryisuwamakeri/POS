@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-8">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-2 sm:mb-3 tracking-tight">
                    Users Management
                </h1>
                <p class="text-brand-akaroa font-medium flex items-center space-x-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    @if($branch)
                        <span>{{ $branch->name }} - {{ $branch->business->name }}</span>
                    @else
                        <span>All Branches</span>
                    @endif
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-brand-husk to-brand-teak hover:from-brand-teak hover:to-brand-indian-khaki text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-sm sm:text-base">Create User</span>
                </a>
                @endif
                <a href="{{ route(dashboard_route()) }}" class="bg-white text-brand-husk font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-brand-albescent-white hover:border-brand-husk flex items-center space-x-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="text-sm sm:text-base">Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card p-8">
            @if($users->count() > 0)
            <div class="mb-4 text-sm text-brand-akaroa">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 via-blue-50/30 to-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-all duration-200 border-b border-slate-100">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $user->display_name ?? $user->name }}</div>
                                <div class="text-sm text-slate-500 font-medium">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 font-medium">{{ $user->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $role = $user->roles->first();
                                    $roleColors = [
                                        'super_admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'admin' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'sales' => 'bg-green-100 text-green-700 border-green-200',
                                        'accounting' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    ];
                                    $colorClass = $roleColors[$role->name ?? ''] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                @endphp
                                <button onclick="openRoleModal({{ $user->id }}, '{{ $user->name }}', {{ $role->id ?? 'null' }})" 
                                        class="px-3 py-1.5 text-xs font-bold rounded-full {{ $colorClass }} border hover:opacity-80 transition-opacity cursor-pointer">
                                    {{ ucfirst(str_replace('_', ' ', $role->name ?? 'No Role')) }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 font-medium">
                                    {{ $user->branch ? $user->branch->name : 'No Branch' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="openRoleModal({{ $user->id }}, '{{ $user->name }}', {{ $role->id ?? 'null' }})" 
                                        class="text-blue-600 hover:text-blue-700 hover:underline">
                                    Manage Role
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-slate-400 font-medium">No users found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Assign Role Modal -->
<div id="role-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 transform transition-all shadow-2xl border border-slate-200">
        <h3 class="text-2xl font-extrabold text-slate-900 mb-6" id="role-user-name">Assign Role</h3>
        <form id="role-form" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Role *</label>
                <select name="role_id" id="role-select" required
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                    <option value="">Select a role</option>
                    @foreach(\Spatie\Permission\Models\Role::orderBy('name')->get() as $r)
                        <option value="{{ $r->id }}">{{ ucfirst(str_replace('_', ' ', $r->name)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                    Assign Role
                </button>
                <button type="button" onclick="closeRoleModal()" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRoleModal(userId, userName, currentRoleId) {
    document.getElementById('role-user-name').textContent = 'Assign Role to ' + userName;
    document.getElementById('role-select').value = currentRoleId || '';
    document.getElementById('role-form').action = '{{ url("/admin/users") }}/' + userId + '/assign-role';
    document.getElementById('role-modal').classList.remove('hidden');
}

function closeRoleModal() {
    document.getElementById('role-modal').classList.add('hidden');
}

document.getElementById('role-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRoleModal();
});
</script>
@endsection

