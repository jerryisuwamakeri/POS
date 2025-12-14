<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses
     */
    public function index()
    {
        $businesses = Business::withCount('branches')
            ->with('branches')
            ->orderBy('name')
            ->paginate(20);

        return view('businesses.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new business
     */
    public function create()
    {
        return view('businesses.create');
    }

    /**
     * Store a newly created business
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subscription_status' => 'required|in:active,inactive,trial',
        ]);

        $business = Business::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'subscription_status' => $request->subscription_status,
        ]);

        return redirect()->route('businesses.index')
            ->with('success', 'Business created successfully');
    }

    /**
     * Display the specified business
     */
    public function show(Business $business)
    {
        $business->load(['branches', 'branches.users', 'branches.orders']);
        
        $stats = [
            'total_branches' => $business->branches->count(),
            'total_users' => $business->branches->sum(fn($b) => $b->users->count()),
            'total_orders' => $business->branches->sum(fn($b) => $b->orders->count()),
            'total_revenue' => $business->branches->sum(fn($b) => $b->orders->where('status', 'paid')->sum('total_amount')),
        ];

        return view('businesses.show', compact('business', 'stats'));
    }

    /**
     * Show the form for editing the specified business
     */
    public function edit(Business $business)
    {
        return view('businesses.edit', compact('business'));
    }

    /**
     * Update the specified business
     */
    public function update(Request $request, Business $business)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subscription_status' => 'required|in:active,inactive,trial',
        ]);

        $business->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'subscription_status' => $request->subscription_status,
        ]);

        return redirect()->route('businesses.index')
            ->with('success', 'Business updated successfully');
    }

    /**
     * Remove the specified business
     */
    public function destroy(Business $business)
    {
        if ($business->branches->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete business with existing branches');
        }

        $business->delete();

        return redirect()->route('businesses.index')
            ->with('success', 'Business deleted successfully');
    }
}

