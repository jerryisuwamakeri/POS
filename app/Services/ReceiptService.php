<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    /**
     * Generate PDF receipt for an order
     *
     * @param Order $order
     * @return Receipt
     */
    public function generateReceipt(Order $order): Receipt
    {
        try {
            // Load relationships
            $order->load(['orderItems.product', 'orderItems.variant', 'user', 'branch.business', 'customer']);

            // Ensure storage directory exists
            $receiptsDir = storage_path('app/receipts');
            if (!file_exists($receiptsDir)) {
                mkdir($receiptsDir, 0755, true);
            }

            // Generate PDF with UTF-8 encoding - use simpler options for reliability
            $pdf = Pdf::loadView('receipts.order', ['order' => $order])
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('isPhpEnabled', true)
                ->setPaper('a4', 'portrait')
                ->setOption('encoding', 'UTF-8');

            // Save to storage
            $filename = 'receipts/' . $order->reference . '-' . time() . '.pdf';
            $pdfContent = $pdf->output();
            
            if (empty($pdfContent)) {
                throw new \Exception('PDF generation failed: Empty PDF content');
            }

            Storage::disk('local')->put($filename, $pdfContent);

            // Create receipt record
            $receipt = Receipt::create([
                'order_id' => $order->id,
                'path' => $filename,
                'printed_at' => now(),
            ]);

            return $receipt;
        } catch (\Exception $e) {
            \Log::error('Receipt generation failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get receipt download URL
     *
     * @param Receipt $receipt
     * @return string
     */
    public function getReceiptUrl(Receipt $receipt): string
    {
        return Storage::disk('local')->url($receipt->path);
    }
}

