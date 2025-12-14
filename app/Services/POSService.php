<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class POSService
{
    /**
     * Process checkout and create order
     *
     * @param array $cartItems Array of cart items with product_id, variant_id (optional), qty
     * @param int $branchId
     * @param int $userId
     * @param string $paymentMethod
     * @param int|null $customerId
     * @return Order
     * @throws \Exception
     */
    public function checkout(
        array $cartItems,
        int $branchId,
        int $userId,
        string $paymentMethod = 'cash',
        ?int $customerId = null
    ): Order {
        return DB::transaction(function () use ($cartItems, $branchId, $userId, $paymentMethod, $customerId) {
            // Get customer if provided
            $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
            $customerName = $customer ? $customer->name : null;
            $totalAmount = 0;
            $orderItems = [];

            // Validate stock and calculate totals
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check if product belongs to branch
                if ($product->branch_id !== $branchId) {
                    throw new \Exception("Product does not belong to this branch");
                }

                // Get variant if specified
                $variant = null;
                if (!empty($item['variant_id'])) {
                    $variant = ProductVariant::where('id', $item['variant_id'])
                        ->where('product_id', $product->id)
                        ->firstOrFail();
                }

                $qty = (int) $item['qty'];
                $unitPrice = $variant ? $variant->price : $product->price;
                $discount = isset($item['discount']) ? to_kobo($item['discount']) : 0;

                // Check stock availability
                $inventory = Inventory::where('branch_id', $branchId)
                    ->where('product_id', $product->id)
                    ->first();

                if (!$inventory || $inventory->qty < $qty) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                // Calculate subtotal
                $subtotal = ($qty * $unitPrice) - $discount;
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product' => $product,
                    'variant' => $variant,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'discount' => $discount,
                    'inventory' => $inventory,
                ];
            }

            if ($totalAmount <= 0) {
                throw new \Exception("Order total must be greater than zero");
            }

            // Generate order reference
            $reference = 'ORD-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'branch_id' => $branchId,
                'user_id' => $userId,
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'status' => 'paid',
                'reference' => $reference,
            ]);

            // Create order items and update inventory
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => $item['variant']?->id,
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'],
                ]);

                // Update inventory
                $item['inventory']->decrement('qty', $item['qty']);
            }

            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'branch_id' => $branchId,
                'amount' => $totalAmount,
                'method' => $paymentMethod,
                'reference' => $reference,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            return $order->load(['orderItems.product', 'orderItems.variant', 'user', 'branch']);
        });
    }
}

