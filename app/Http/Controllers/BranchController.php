<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Business;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of branches
     */
    public function index(Request $request)
    {
        $query = Branch::with('business');

        if ($request->has('business_id')) {
            $query->where('business_id', $request->business_id);
        }

        $branches = $query->withCount(['users', 'orders', 'products'])
            ->orderBy('name')
            ->paginate(20);

        $businesses = Business::orderBy('name')->get();

        return view('branches.index', compact('branches', 'businesses'));
    }

    /**
     * Show the form for creating a new branch
     */
    public function create()
    {
        $businesses = Business::orderBy('name')->get();
        return view('branches.create', compact('businesses'));
    }

    /**
     * Store a newly created branch
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
            'geo_lat' => 'nullable|numeric',
            'geo_lng' => 'nullable|numeric',
        ]);

        Branch::create($request->only([
            'business_id',
            'name',
            'location',
            'geo_lat',
            'geo_lng',
        ]));

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully');
    }

    /**
     * Display the specified branch
     */
    public function show(Branch $branch)
    {
        $branch->load(['business', 'users', 'products', 'orders']);

        // Use Collection filtering for date comparisons
        $today = today()->format('Y-m-d');
        $todayOrders = $branch->orders->filter(function ($order) use ($today) {
            return $order->created_at->format('Y-m-d') === $today;
        });

        $stats = [
            'total_users' => $branch->users->count(),
            'total_products' => $branch->products->count(),
            'total_orders' => $branch->orders->count(),
            'total_revenue' => $branch->orders->where('status', 'paid')->sum('total_amount'),
            'today_orders' => $todayOrders->count(),
            'today_revenue' => $todayOrders->where('status', 'paid')->sum('total_amount'),
        ];

        return view('branches.show', compact('branch', 'stats'));
    }

    /**
     * Show the form for editing the specified branch
     */
    public function edit(Branch $branch)
    {
        $businesses = Business::orderBy('name')->get();
        return view('branches.edit', compact('branch', 'businesses'));
    }

    /**
     * Update the specified branch
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
            'geo_lat' => 'nullable|numeric',
            'geo_lng' => 'nullable|numeric',
        ]);

        $branch->update($request->only([
            'business_id',
            'name',
            'location',
            'geo_lat',
            'geo_lng',
        ]));

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully');
    }

    /**
     * Remove the specified branch
     */
    public function destroy(Branch $branch)
    {
        if ($branch->users->count() > 0 || $branch->orders->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete branch with existing users or orders');
        }

        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully');
    }
}

