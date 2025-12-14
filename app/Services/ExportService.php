<?php

namespace App\Services;

use App\Models\Export;
use App\Models\Order;
use App\Models\Expense;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExportService
{
    /**
     * Export sales report to CSV
     *
     * @param int $userId
     * @param int|null $branchId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return Export
     */
    public function exportSalesReport(
        int $userId,
        ?int $branchId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): Export {
        $export = Export::create([
            'user_id' => $userId,
            'type' => 'sales_report',
            'params' => [
                'branch_id' => $branchId,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'status' => 'pending',
        ]);

        try {
            $query = Order::query();

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $orders = $query->with(['user', 'branch', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate CSV content
            $csvContent = "Order Reference,Date,Customer,Branch,User,Total Amount,Status\n";

            foreach ($orders as $order) {
                $csvContent .= sprintf(
                    "%s,%s,%s,%s,%s,%s,%s\n",
                    $order->reference,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->customer_name ?? 'N/A',
                    $order->branch->name,
                    $order->user->display_name ?? $order->user->name,
                    format_money($order->total_amount),
                    $order->status
                );
            }

            // Save to storage
            $filename = 'exports/sales-report-' . time() . '.csv';
            Storage::disk('local')->put($filename, $csvContent);

            $export->update([
                'path' => $filename,
                'status' => 'completed',
            ]);

            return $export;
        } catch (\Exception $e) {
            $export->update([
                'status' => 'failed',
            ]);

            throw $e;
        }
    }

    /**
     * Export expenses report to CSV
     *
     * @param int $userId
     * @param int|null $branchId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return Export
     */
    public function exportExpensesReport(
        int $userId,
        ?int $branchId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): Export {
        $export = Export::create([
            'user_id' => $userId,
            'type' => 'expenses',
            'params' => [
                'branch_id' => $branchId,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'status' => 'pending',
        ]);

        try {
            $query = Expense::query();

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $expenses = $query->with(['user', 'branch'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Generate CSV content
            $csvContent = "Date,Title,Category,Branch,User,Amount\n";

            foreach ($expenses as $expense) {
                $csvContent .= sprintf(
                    "%s,%s,%s,%s,%s,%s\n",
                    $expense->created_at->format('Y-m-d H:i:s'),
                    $expense->title,
                    $expense->category ?? 'N/A',
                    $expense->branch->name,
                    $expense->user->display_name ?? $expense->user->name,
                    format_money($expense->amount)
                );
            }

            // Save to storage
            $filename = 'exports/expenses-' . time() . '.csv';
            Storage::disk('local')->put($filename, $csvContent);

            $export->update([
                'path' => $filename,
                'status' => 'completed',
            ]);

            return $export;
        } catch (\Exception $e) {
            $export->update([
                'status' => 'failed',
            ]);

            throw $e;
        }
    }
}

