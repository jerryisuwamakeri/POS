<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branch = $user->branch;

        $query = Order::with(['user', 'branch.business', 'orderItems.product']);

        // Filter by branch if user has one
        if ($branch) {
            $query->where('branch_id', $branch->id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $stats = [
            'total' => $query->count(),
            'paid' => (clone $query)->where('status', 'paid')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'total_revenue' => (clone $query)->where('status', 'paid')->sum('total_amount'),
        ];

        return view('orders.index', compact('orders', 'stats', 'branch'));
    }

    /**
     * Show a specific order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'branch.business', 'orderItems.product', 'payments', 'receipt']);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order)
    {
        // Authorization check - only admin and super_admin can delete orders
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('super_admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Check branch access if user has a branch
        if ($user->branch && $order->branch_id !== $user->branch_id) {
            abort(403, 'You can only delete orders from your branch.');
        }

        try {
            // Delete related records
            $order->orderItems()->delete();
            $order->payments()->delete();
            
            // Delete receipt file if exists
            if ($order->receipt) {
                $receipt = $order->receipt;
                if ($receipt->path && \Storage::disk('local')->exists($receipt->path)) {
                    \Storage::disk('local')->delete($receipt->path);
                }
                $receipt->delete();
            }

            // Delete the order
            $orderReference = $order->reference;
            $order->delete();

            return redirect()->route('orders.index')
                ->with('success', "Order {$orderReference} has been deleted successfully.");
        } catch (\Exception $e) {
            \Log::error('Failed to delete order: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => $user->id,
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete order. Please try again.');
        }
    }
}

