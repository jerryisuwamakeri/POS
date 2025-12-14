<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display inventory list
     */
    public function index()
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        $inventories = Inventory::where('branch_id', $branch->id)
            ->with('product')
            ->orderBy('qty', 'asc')
            ->paginate(50);

        return view('inventory.index', compact('inventories', 'branch'));
    }

    /**
     * Update inventory quantity
     */
    public function update(Request $request, Inventory $inventory)
    {
        // Role middleware already handles authorization

        $request->validate([
            'qty' => 'required|integer|min:0',
            'min_threshold' => 'nullable|integer|min:0',
        ]);

        $inventory->update([
            'qty' => $request->qty,
            'min_threshold' => $request->min_threshold ?? $inventory->min_threshold,
        ]);

        return redirect()->back()->with('success', 'Inventory updated successfully');
    }

    /**
     * Adjust inventory (add or remove stock)
     */
    public function adjust(Request $request, Inventory $inventory)
    {
        // Role middleware already handles authorization

        $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'nullable|string|max:500',
        ]);

        $oldQty = $inventory->qty;
        $newQty = max(0, $oldQty + $request->adjustment);

        $inventory->update(['qty' => $newQty]);

        // Log the adjustment (you can create an inventory_history table later)
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'adjusted',
            'auditable_type' => Inventory::class,
            'auditable_id' => $inventory->id,
            'ip_address' => $request->ip(),
            'meta' => [
                'old_qty' => $oldQty,
                'new_qty' => $newQty,
                'adjustment' => $request->adjustment,
                'reason' => $request->reason,
            ],
        ]);

        return redirect()->back()->with('success', 'Inventory adjusted successfully');
    }
}

