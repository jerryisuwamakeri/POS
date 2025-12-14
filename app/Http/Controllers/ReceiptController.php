<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    /**
     * Show receipt for printing
     */
    public function show($receipt)
    {
        // Try to find receipt by ID first
        $receiptModel = \App\Models\Receipt::find($receipt);
        
        if ($receiptModel) {
            $receiptModel->load([
                'order.orderItems.product', 
                'order.orderItems.variant', 
                'order.user', 
                'order.branch.business',
                'order.customer'
            ]);
            
            return view('receipts.print', ['order' => $receiptModel->order, 'receipt' => $receiptModel]);
        }
        
        // Fallback: try to find by order_id
        $receiptModel = \App\Models\Receipt::where('order_id', $receipt)->first();
        if ($receiptModel) {
            $receiptModel->load([
                'order.orderItems.product', 
                'order.orderItems.variant', 
                'order.user', 
                'order.branch.business',
                'order.customer'
            ]);
            
            return view('receipts.print', ['order' => $receiptModel->order, 'receipt' => $receiptModel]);
        }
        
        // Last resort: get order directly (for cases where receipt generation failed)
        $order = \App\Models\Order::with([
            'orderItems.product', 
            'orderItems.variant', 
            'user', 
            'branch.business',
            'customer'
        ])->find($receipt);
        
        if ($order) {
            return view('receipts.print', ['order' => $order, 'receipt' => null]);
        }
        
        abort(404, 'Receipt not found');
    }

    /**
     * Download receipt PDF
     */
    public function download($receipt)
    {
        // Try to find receipt by ID first
        $receiptModel = Receipt::with('order')->find($receipt);
        
        if (!$receiptModel) {
            // Try to find by order_id
            $receiptModel = Receipt::with('order')->where('order_id', $receipt)->first();
        }
        
        if (!$receiptModel) {
            abort(404, 'Receipt not found');
        }

        // Ensure order is loaded
        if (!$receiptModel->order) {
            abort(404, 'Order not found for this receipt');
        }

        // Check if file exists
        if (!Storage::disk('local')->exists($receiptModel->path)) {
            // Try to regenerate the receipt if file is missing
            try {
                $receiptService = new \App\Services\ReceiptService();
                $receiptModel = $receiptService->generateReceipt($receiptModel->order);
            } catch (\Exception $e) {
                \Log::error('Failed to regenerate receipt: ' . $e->getMessage(), [
                    'receipt_id' => $receiptModel->id,
                    'order_id' => $receiptModel->order_id,
                ]);
                abort(404, 'Receipt file not found and could not be regenerated: ' . $e->getMessage());
            }
        }

        // Get the file path
        $filePath = storage_path('app/' . $receiptModel->path);
        
        if (!file_exists($filePath)) {
            \Log::error('Receipt file path does not exist', [
                'receipt_id' => $receiptModel->id,
                'path' => $receiptModel->path,
                'full_path' => $filePath,
            ]);
            abort(404, 'Receipt file not found at: ' . $receiptModel->path);
        }

        return response()->download($filePath, 'receipt-' . $receiptModel->order->reference . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

