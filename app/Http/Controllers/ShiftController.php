<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Clock in
     */
    public function clockIn(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Branch not selected'], 400);
            }
            return redirect()->route('branches.select')->with('error', 'Please select a branch first.');
        }

        // Check if user already has an active shift
        $activeShift = $user->activeShift;
        if ($activeShift) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You already have an active shift'], 400);
            }
            return redirect()->route('shifts.index')->with('error', 'You already have an active shift');
        }

        $shift = Shift::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'clock_in_at' => now(),
            'geo_lat' => $request->input('geo_lat'),
            'geo_lng' => $request->input('geo_lng'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'shift' => $shift,
                'message' => 'Clocked in successfully',
            ]);
        }

        return redirect()->route('shifts.index')->with('success', 'Clocked in successfully');
    }

    /**
     * Clock out
     */
    public function clockOut(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $activeShift = $user->activeShift;

        if (!$activeShift) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No active shift found'], 400);
            }
            return redirect()->route('shifts.index')->with('error', 'No active shift found');
        }

        $activeShift->update([
            'clock_out_at' => now(),
            'duration_minutes' => $activeShift->calculateDuration(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'shift' => $activeShift->fresh(),
                'message' => 'Clocked out successfully',
            ]);
        }

        return redirect()->route('shifts.index')->with('success', 'Clocked out successfully');
    }

    /**
     * Get user's shifts
     */
    public function index(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        $query = Shift::where('user_id', $user->id);

        if ($branch) {
            $query->where('branch_id', $branch->id);
        }

        if ($request->has('start_date')) {
            $query->whereDate('clock_in_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('clock_in_at', '<=', $request->end_date);
        }

        $shifts = $query->with('branch')
            ->orderBy('clock_in_at', 'desc')
            ->paginate(20);

        return view('attendance.index', compact('shifts'));
    }
}

