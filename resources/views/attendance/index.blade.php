@extends('layouts.app')

@section('title', 'Attendance & Shifts')

@section('content')
<div class="min-h-screen animate-fade-in">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8 lg:mb-10">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-2 sm:mb-3 tracking-tight">
                    Attendance & Shifts
                </h1>
                <p class="text-brand-akaroa font-medium text-sm sm:text-base lg:text-lg">Track your work hours and attendance</p>
            </div>
        </div>

        @php
            $user = auth()->user();
            $activeShift = $user->activeShift;
        @endphp

        <!-- Clock In/Out Card -->
        <div class="card-glass p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 lg:mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 sm:gap-6">
                <div class="flex-1">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-brand-husk mb-3 sm:mb-4">Current Status</h2>
                    @if($activeShift)
                        <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                            <div class="w-3 h-3 sm:w-4 sm:h-4 bg-gradient-to-r from-brand-teak to-brand-indian-khaki rounded-full animate-pulse shadow-lg shadow-brand-teak/50"></div>
                            <p class="text-base sm:text-lg font-semibold text-brand-teak">You are clocked in</p>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-gradient-to-r from-brand-off-yellow/30 to-brand-albescent-white/30 rounded-lg sm:rounded-xl p-3 sm:p-4 border border-brand-albescent-white">
                                <p class="text-xs sm:text-sm font-semibold text-brand-akaroa mb-1 sm:mb-2">Started</p>
                                <p class="text-base sm:text-lg lg:text-xl font-bold text-brand-husk">{{ $activeShift->clock_in_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-brand-teak/20 via-brand-indian-khaki/20 to-brand-akaroa/20 rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2 border-brand-teak/30 shadow-lg">
                                <p class="text-xs sm:text-sm font-semibold text-brand-teak mb-2 sm:mb-3 uppercase tracking-wide">Current Duration</p>
                                @php
                                    $durationSeconds = $activeShift->clock_in_at->diffInSeconds(now());
                                    $initialHours = floor($durationSeconds / 3600);
                                    $initialMinutes = floor(($durationSeconds % 3600) / 60);
                                    $initialSeconds = $durationSeconds % 60;
                                    $initialDuration = sprintf('%02d:%02d:%02d', $initialHours, $initialMinutes, $initialSeconds);
                                @endphp
                                <p class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-brand-husk font-mono tracking-wider" id="shift-duration" data-start-time="{{ $activeShift->clock_in_at->timestamp }}">{{ $initialDuration }}</p>
                                <p class="text-xs sm:text-sm text-brand-akaroa mt-2">Live timer updating every second</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                            <div class="w-3 h-3 sm:w-4 sm:h-4 bg-brand-akaroa rounded-full"></div>
                            <p class="text-base sm:text-lg font-semibold text-brand-akaroa">You are clocked out</p>
                        </div>
                        <p class="text-brand-akaroa text-sm sm:text-base">Click the button below to start your shift</p>
                    @endif
                </div>
                <div class="lg:ml-8 flex-shrink-0">
                    @if($activeShift)
                        <form method="POST" action="{{ route('shifts.clock-out') }}" id="clock-out-form">
                            @csrf
                            <button type="submit" class="w-full lg:w-auto bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl shadow-lg shadow-red-500/25 hover:shadow-red-500/40 transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm sm:text-base lg:text-lg">Clock Out</span>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('shifts.clock-in') }}" id="clock-in-form">
                            @csrf
                            <button type="submit" class="w-full lg:w-auto bg-gradient-to-r from-brand-husk to-brand-teak hover:from-brand-teak hover:to-brand-indian-khaki text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl shadow-lg shadow-brand-husk/25 hover:shadow-brand-husk/40 transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm sm:text-base lg:text-lg">Clock In</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shifts History -->
        <div class="card-glass p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4 sm:mb-6">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-brand-husk">Shift History</h2>
                <form method="GET" action="{{ route('shifts.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="input-modern text-sm sm:text-base px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-brand-albescent-white focus:border-brand-husk focus:ring-2 focus:ring-brand-husk/20">
                    <span class="text-brand-akaroa text-sm sm:text-base self-center">to</span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="input-modern text-sm sm:text-base px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-brand-albescent-white focus:border-brand-husk focus:ring-2 focus:ring-brand-husk/20">
                    <button type="submit" class="bg-gradient-to-r from-brand-husk to-brand-teak hover:from-brand-teak hover:to-brand-indian-khaki text-white font-semibold px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 text-sm sm:text-base">Filter</button>
                </form>
            </div>

            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-brand-albescent-white">
                        <thead class="bg-gradient-to-r from-brand-off-yellow/50 via-brand-albescent-white/50 to-brand-off-yellow/50 border-b-2 border-brand-albescent-white">
                            <tr>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-left text-[10px] sm:text-xs font-bold text-brand-husk uppercase tracking-wider">Date</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-left text-[10px] sm:text-xs font-bold text-brand-husk uppercase tracking-wider">Clock In</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-left text-[10px] sm:text-xs font-bold text-brand-husk uppercase tracking-wider">Clock Out</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-left text-[10px] sm:text-xs font-bold text-brand-husk uppercase tracking-wider">Duration</th>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-left text-[10px] sm:text-xs font-bold text-brand-husk uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-brand-albescent-white">
                            @forelse($shifts as $shift)
                            <tr class="hover:bg-brand-off-yellow/20 transition-all duration-200">
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-semibold text-brand-husk">{{ $shift->clock_in_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-brand-husk">{{ $shift->clock_in_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-brand-husk">
                                        {{ $shift->clock_out_at ? $shift->clock_out_at->format('h:i A') : '-' }}
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    @if($shift->isActive())
                                        <div class="text-xs sm:text-sm font-semibold text-brand-teak">Active</div>
                                    @elseif($shift->clock_out_at)
                                        <div class="text-xs sm:text-sm font-semibold text-brand-husk font-mono">
                                            {{ $shift->formatted_duration }}
                                        </div>
                                    @else
                                        <div class="text-xs sm:text-sm text-brand-akaroa">-</div>
                                    @endif
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    @if($shift->isActive())
                                        <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gradient-to-r from-brand-teak/20 to-brand-indian-khaki/20 text-brand-teak border border-brand-teak/30">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-brand-albescent-white/50 text-brand-indian-khaki border border-brand-akaroa/30">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg class="w-12 h-12 text-brand-akaroa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-brand-akaroa font-medium text-sm sm:text-base">No shifts found</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($shifts->hasPages())
            <div class="mt-4 sm:mt-6">
                {{ $shifts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Update duration in real-time for active shift
@if($activeShift)
document.addEventListener('DOMContentLoaded', function() {
    const durationElement = document.getElementById('shift-duration');
    if (!durationElement) {
        console.error('shift-duration element not found');
        return;
    }
    
    // Get the start timestamp from data attribute (Unix timestamp in seconds)
    const startTimestamp = parseInt(durationElement.getAttribute('data-start-time'));
    if (!startTimestamp || isNaN(startTimestamp)) {
        console.error('Invalid start timestamp');
        return;
    }
    
    // Convert Unix timestamp (seconds) to milliseconds
    const startTime = startTimestamp * 1000;
    
    function updateDuration() {
        const now = Date.now();
        const diffMs = now - startTime;
        
        if (diffMs < 0) {
            durationElement.textContent = '00:00:00';
            return;
        }
        
        const totalSeconds = Math.floor(diffMs / 1000);
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;
        
        // Format as HH:MM:SS with padding
        const formatted = String(hours).padStart(2, '0') + ':' + 
                         String(minutes).padStart(2, '0') + ':' + 
                         String(seconds).padStart(2, '0');
        
        durationElement.textContent = formatted;
    }
    
    // Update immediately
    updateDuration();
    
    // Update every second
    const intervalId = setInterval(updateDuration, 1000);
    
    // Clean up interval when page is hidden (optional optimization)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(intervalId);
        } else {
            updateDuration();
            setInterval(updateDuration, 1000);
        }
    });
});
@endif

// Handle clock in/out with better UX
document.getElementById('clock-in-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const button = form.querySelector('button');
    const originalText = button.textContent;
    
    button.disabled = true;
    button.textContent = 'Clocking in...';
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Failed to clock in');
            button.disabled = false;
            button.textContent = originalText;
        }
    })
    .catch(error => {
        alert('An error occurred');
        button.disabled = false;
        button.textContent = originalText;
    });
});

document.getElementById('clock-out-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    if (!confirm('Are you sure you want to clock out?')) return;
    
    const form = this;
    const button = form.querySelector('button');
    const originalText = button.textContent;
    
    button.disabled = true;
    button.textContent = 'Clocking out...';
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Failed to clock out');
            button.disabled = false;
            button.textContent = originalText;
        }
    })
    .catch(error => {
        alert('An error occurred');
        button.disabled = false;
        button.textContent = originalText;
    });
});
</script>
@endpush
@endsection
