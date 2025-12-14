<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Expense;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show super admin dashboard
     */
    public function superAdmin()
    {
        // Role middleware already handles authorization

        $stats = [
            'total_businesses' => \App\Models\Business::count(),
            'total_branches' => \App\Models\Branch::count(),
            'total_users' => \App\Models\User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'paid')
                ->sum('total_amount'),
        ];

        // Get businesses with branch counts
        $businesses = \App\Models\Business::withCount('branches')
            ->with('branches')
            ->orderBy('name')
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['user', 'branch.business', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get top branches by revenue
        $topBranches = \App\Models\Branch::with('business')
            ->withCount(['orders', 'users'])
            ->withSum(['orders as total_revenue' => function($query) {
                $query->where('status', 'paid');
            }], 'total_amount')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('dashboards.super_admin', compact('stats', 'businesses', 'recentOrders', 'topBranches'));
    }

    /**
     * Show admin dashboard
     */
    public function admin()
    {
        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        // Today's stats
        $todayOrders = Order::where('branch_id', $branch->id)
            ->whereDate('created_at', today())
            ->count();

        $todayRevenue = Order::where('branch_id', $branch->id)
            ->whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('total_amount');

        $lowStockProducts = \App\Models\Inventory::where('branch_id', $branch->id)
            ->whereColumn('qty', '<=', 'min_threshold')
            ->with('product')
            ->get();

        $recentOrders = Order::where('branch_id', $branch->id)
            ->with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Chart data - Last 7 days revenue
        $chartData = Order::where('branch_id', $branch->id)
            ->where('status', 'paid')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chart data - Last 7 days orders count
        $ordersChartData = Order::where('branch_id', $branch->id)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $stats = [
            'today_orders' => $todayOrders,
            'today_revenue' => $todayRevenue,
            'low_stock_count' => $lowStockProducts->count(),
        ];

        return view('dashboards.admin', compact('stats', 'lowStockProducts', 'recentOrders', 'branch', 'chartData', 'ordersChartData'));
    }

    /**
     * Show sales dashboard
     */
    public function sales()
    {
        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        // Active shift
        $activeShift = $user->activeShift;

        // Today's sales
        $todaySales = Order::where('branch_id', $branch->id)
            ->where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('total_amount');

        $todayOrders = Order::where('branch_id', $branch->id)
            ->where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        $stats = [
            'today_sales' => $todaySales,
            'today_orders' => $todayOrders,
            'has_active_shift' => $activeShift !== null,
        ];

        return view('dashboards.sales', compact('stats', 'activeShift', 'branch'));
    }

    /**
     * Show accounting dashboard
     */
    public function accounting()
    {
        $user = Auth::user();
        $branch = $user->branch;

        if (!$branch) {
            return redirect()->route('branches.select')
                ->with('error', 'Please select a branch first.');
        }

        // Revenue stats
        $todayRevenue = Order::where('branch_id', $branch->id)
            ->whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('total_amount');

        $monthRevenue = Order::where('branch_id', $branch->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->sum('total_amount');

        // Expense stats
        $todayExpenses = Expense::where('branch_id', $branch->id)
            ->whereDate('created_at', today())
            ->sum('amount');

        $monthExpenses = Expense::where('branch_id', $branch->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Recent transactions
        $recentPayments = \App\Models\Payment::where('branch_id', $branch->id)
            ->with(['order', 'order.user'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $recentExpenses = Expense::where('branch_id', $branch->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Chart data - Last 30 days revenue vs expenses
        $revenueChartData = Order::where('branch_id', $branch->id)
            ->where('status', 'paid')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $expensesChartData = Expense::where('branch_id', $branch->id)
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as expenses')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment methods breakdown
        $paymentMethodsData = \App\Models\Payment::where('branch_id', $branch->id)
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->where('status', 'completed')
            ->selectRaw('method, SUM(amount) as total')
            ->groupBy('method')
            ->get();

        $stats = [
            'today_revenue' => $todayRevenue,
            'month_revenue' => $monthRevenue,
            'today_expenses' => $todayExpenses,
            'month_expenses' => $monthExpenses,
            'net_profit' => $monthRevenue - $monthExpenses,
        ];

        return view('dashboards.accounting', compact('stats', 'recentPayments', 'recentExpenses', 'branch', 'revenueChartData', 'expensesChartData', 'paymentMethodsData'));
    }
}

