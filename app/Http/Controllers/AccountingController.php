<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Show expenses
     */
    public function expenses(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        $query = Expense::where('branch_id', $branch->id);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $expenses = $query->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('accounting.expenses', compact('expenses', 'branch'));
    }

    /**
     * Create expense
     */
    public function createExpense(Request $request)
    {
        // Role middleware already handles authorization

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return response()->json(['error' => 'Branch not selected'], 400);
        }

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('expenses', 'local');
        }

        $expense = Expense::create([
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'title' => $request->title,
            'amount' => to_kobo($request->amount),
            'category' => $request->category,
            'receipt_path' => $receiptPath,
        ]);

        return redirect()->back()->with('success', 'Expense created successfully');
    }

    /**
     * Export sales report
     */
    public function exportSalesReport(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        try {
            $export = $this->exportService->exportSalesReport(
                $user->id,
                $branch?->id,
                $request->start_date,
                $request->end_date
            );

            return response()->download(
                storage_path('app/' . $export->path),
                'sales-report-' . now()->format('Y-m-d') . '.csv'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export: ' . $e->getMessage());
        }
    }

    /**
     * Export expenses report
     */
    public function exportExpensesReport(Request $request)
    {
        // Role middleware already handles authorization

        $user = Auth::user();
        $branch = $user->branch;

        try {
            $export = $this->exportService->exportExpensesReport(
                $user->id,
                $branch?->id,
                $request->start_date,
                $request->end_date
            );

            return response()->download(
                storage_path('app/' . $export->path),
                'expenses-' . now()->format('Y-m-d') . '.csv'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export: ' . $e->getMessage());
        }
    }
}

