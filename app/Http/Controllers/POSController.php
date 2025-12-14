<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Customer;
use App\Services\POSService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class POSController extends Controller
{
    protected $posService;
    protected $receiptService;

    public function __construct(POSService $posService, ReceiptService $receiptService)
    {
        $this->posService = $posService;
        $this->receiptService = $receiptService;
    }

    /**
     * Show POS terminal
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

        // Get ALL active products for this branch (no inventory filtering - show all products)
        $products = Product::where('branch_id', $branch->id)
            ->where('active', true)
            ->with(['variants', 'inventories' => function ($query) use ($branch) {
                $query->where('branch_id', $branch->id);
            }, 'category'])
            ->orderBy('name')
            ->get();
        
        // Ensure we have products - log if empty for debugging
        if ($products->isEmpty()) {
            \Log::warning('POS: No products found for branch', [
                'branch_id' => $branch->id,
                'user_id' => $user->id,
                'total_products_in_branch' => Product::where('branch_id', $branch->id)->count(),
                'active_products_in_branch' => Product::where('branch_id', $branch->id)->where('active', true)->count(),
            ]);
        }

        // Get customers for this branch
        $customers = Customer::where('active', true)
            ->where(function($q) use ($branch) {
                $q->where('branch_id', $branch->id)
                  ->orWhereNull('branch_id'); // Include global customers
            })
            ->orderBy('name')
            ->get();

        return view('pos.terminal', compact('products', 'branch', 'customers'));
    }

    /**
     * Get products for POS (API endpoint)
     */
    public function getProducts()
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return response()->json(['error' => 'Branch not selected'], 400);
        }

        // Get all active products for this branch
        $products = Product::where('branch_id', $branch->id)
            ->where('active', true)
            ->with(['variants', 'inventories' => function ($query) use ($branch) {
                $query->where('branch_id', $branch->id);
            }, 'category'])
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                $inventory = $product->inventories->first();
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'formatted_price' => $product->formatted_price,
                    'unit' => $product->unit,
                    'stock' => $inventory ? $inventory->qty : 0,
                    'variants' => $product->variants->map(function ($variant) {
                        return [
                            'id' => $variant->id,
                            'name' => $variant->name,
                            'price' => $variant->price,
                            'formatted_price' => $variant->formatted_price,
                            'stock' => $variant->stock,
                        ];
                    }),
                ];
            });

        return response()->json($products);
    }

    /**
     * Process checkout
     */
    public function checkout(Request $request)
    {
        // Role middleware already handles authorization

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,wallet,pos',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return response()->json(['error' => 'Branch not selected'], 400);
        }

        try {
            $order = $this->posService->checkout(
                $request->items,
                $branch->id,
                $user->id,
                $request->payment_method,
                $request->customer_id
            );

            // Generate receipt - if it fails, still return a receipt URL using order
            $receiptUrl = null;
            try {
                $receipt = $this->receiptService->generateReceipt($order);
                $receiptUrl = route('receipts.show', $receipt->id);
            } catch (\Exception $receiptError) {
                // If receipt generation fails, create receipt record anyway and use order-based URL
                Log::warning('Receipt PDF generation failed, using fallback', [
                    'order_id' => $order->id,
                    'error' => $receiptError->getMessage()
                ]);
                
                // Try to create receipt record without PDF
                try {
                    $receipt = \App\Models\Receipt::create([
                        'order_id' => $order->id,
                        'path' => 'receipts/fallback-' . $order->reference . '.pdf',
                        'printed_at' => now(),
                    ]);
                    $receiptUrl = route('receipts.show', $receipt->id);
                } catch (\Exception $e) {
                    // Last resort: use order ID to show receipt
                    $receiptUrl = route('receipts.show', ['receipt' => $order->id]);
                }
            }

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'reference' => $order->reference,
                    'total_amount' => $order->total_amount,
                    'formatted_total' => format_money($order->total_amount),
                ],
                'receipt_url' => $receiptUrl,
            ]);
        } catch (\Exception $e) {
            \Log::error('POS Checkout failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'branch_id' => $branch->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null,
            ], 400);
        }
    }
}

