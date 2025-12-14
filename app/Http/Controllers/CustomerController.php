<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branch = $user->branch;

        $query = Customer::query();

        // Filter by branch if user has a branch
        if ($branch) {
            $query->where(function($q) use ($branch) {
                $q->where('branch_id', $branch->id)
                  ->orWhereNull('branch_id'); // Include global customers
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by active status
        if ($request->has('active')) {
            $query->where('active', $request->active === '1');
        }

        $customers = $query->with('branch')
            ->orderBy('name')
            ->paginate(20);

        return view('customers.index', compact('customers', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $branch = $user->branch;
        $branches = Branch::orderBy('name')->get();

        return view('customers.create', compact('branch', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'active' => 'boolean',
        ]);

        $user = Auth::user();
        
        // If branch_id is not provided, use user's branch
        if (!isset($validated['branch_id']) && $user->branch) {
            $validated['branch_id'] = $user->branch->id;
        }

        $validated['active'] = $request->has('active') ? true : ($validated['active'] ?? true);

        $customer = Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['branch', 'orders' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(10);
        }]);

        $stats = [
            'total_orders' => $customer->orders()->count(),
            'total_spent' => $customer->orders()->where('status', 'paid')->sum('total_amount'),
            'last_order' => $customer->orders()->latest()->first(),
        ];

        return view('customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $user = Auth::user();
        $branch = $user->branch;
        $branches = Branch::orderBy('name')->get();

        return view('customers.edit', compact('customer', 'branch', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active') ? true : ($validated['active'] ?? $customer->active);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->route('customers.index')
                ->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Search customers for POS (API endpoint)
     */
    public function search(Request $request)
    {
        $user = Auth::user();
        $branch = $user->branch;

        $query = Customer::where('active', true);

        if ($branch) {
            $query->where(function($q) use ($branch) {
                $q->where('branch_id', $branch->id)
                  ->orWhereNull('branch_id');
            });
        }

        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('name')
            ->limit(20)
            ->get()
            ->map(function($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ];
            });

        return response()->json($customers);
    }
}
