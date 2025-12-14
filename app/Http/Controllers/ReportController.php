<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show sales reports and analytics
     */
    public function sales(Request $request)
    {
        $user = Auth::user();
        $branch = $user->branch;

        // Date range defaults
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $query = Order::where('status', 'paid');

        if ($branch) {
            $query->where('branch_id', $branch->id);
        }

        $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Overall stats
        $stats = [
            'total_revenue' => (clone $query)->sum('total_amount'),
            'total_orders' => (clone $query)->count(),
            'average_order_value' => (clone $query)->avg('total_amount') ?? 0,
            'total_expenses' => Expense::where('branch_id', $branch?->id)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->sum('amount'),
        ];

        $stats['net_profit'] = $stats['total_revenue'] - $stats['total_expenses'];
        $stats['profit_margin'] = $stats['total_revenue'] > 0 
            ? (($stats['net_profit'] / $stats['total_revenue']) * 100) 
            : 0;

        // Daily revenue chart data (SQLite compatible)
        $dailyRevenue = (clone $query)
            ->selectRaw("strftime('%Y-%m-%d', created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top products
        $topProducts = OrderItem::whereHas('order', function($q) use ($branch, $startDate, $endDate) {
            $q->where('status', 'paid')
              ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            if ($branch) {
                $q->where('branch_id', $branch->id);
            }
        })
        ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(qty * unit_price) as total_revenue'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_revenue', 'desc')
        ->limit(10)
        ->get();

        // Payment method breakdown
        $paymentMethods = (clone $query)
            ->select('payment_method', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        // Hourly sales pattern (SQLite compatible)
        $hourlySales = (clone $query)
            ->selectRaw("CAST(strftime('%H', created_at) AS INTEGER) as hour, SUM(total_amount) as revenue, COUNT(*) as orders")
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return view('reports.sales', compact('stats', 'dailyRevenue', 'topProducts', 'paymentMethods', 'hourlySales', 'branch', 'startDate', 'endDate'));
    }

    /**
     * Show profit analysis report
     */
    public function profit(Request $request)
    {
        $user = Auth::user();
        $branch = $user->branch;

        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Revenue
        $revenueQuery = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        if ($branch) {
            $revenueQuery->where('branch_id', $branch->id);
        }

        $revenue = $revenueQuery->sum('total_amount');

        // Expenses
        $expenseQuery = Expense::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        if ($branch) {
            $expenseQuery->where('branch_id', $branch->id);
        }
        $expenses = $expenseQuery->sum('amount');

        // Product costs (if available)
        $productCosts = OrderItem::whereHas('order', function($q) use ($branch, $startDate, $endDate) {
            $q->where('status', 'paid')
              ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            if ($branch) {
                $q->where('branch_id', $branch->id);
            }
        })
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('SUM(order_items.qty * COALESCE(products.cost, 0)) as total_cost')
        ->value('total_cost') ?? 0;

        $grossProfit = $revenue - $productCosts;
        $netProfit = $grossProfit - $expenses;
        $grossMargin = $revenue > 0 ? (($grossProfit / $revenue) * 100) : 0;
        $netMargin = $revenue > 0 ? (($netProfit / $revenue) * 100) : 0;

        // Daily profit trend (SQLite compatible)
        $dailyProfit = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->when($branch, fn($q) => $q->where('branch_id', $branch->id))
            ->selectRaw("strftime('%Y-%m-%d', created_at) as date, SUM(total_amount) as revenue")
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) use ($startDate, $endDate, $branch) {
                $dayExpenses = Expense::whereDate('created_at', $item->date)
                    ->when($branch, fn($q) => $q->where('branch_id', $branch->id))
                    ->sum('amount');
                return [
                    'date' => $item->date,
                    'revenue' => $item->revenue,
                    'expenses' => $dayExpenses,
                    'profit' => $item->revenue - $dayExpenses,
                ];
            });

        $stats = [
            'revenue' => $revenue,
            'product_costs' => $productCosts,
            'expenses' => $expenses,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'gross_margin' => $grossMargin,
            'net_margin' => $netMargin,
        ];

        return view('reports.profit', compact('stats', 'dailyProfit', 'branch', 'startDate', 'endDate'));
    }
}

