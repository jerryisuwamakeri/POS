<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes (role-based)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return redirect()->route('dashboard.super-admin');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('sales')) {
            return redirect()->route('dashboard.sales');
        } elseif ($user->hasRole('accounting')) {
            return redirect()->route('dashboard.accounting');
        }
        
        return redirect('/login');
    })->name('dashboard');

    Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])
        ->name('dashboard.super-admin')
        ->middleware('role:super_admin');

    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin')
        ->middleware('role:admin');

    Route::get('/dashboard/sales', [DashboardController::class, 'sales'])
        ->name('dashboard.sales')
        ->middleware('role:sales');

    Route::get('/dashboard/accounting', [DashboardController::class, 'accounting'])
        ->name('dashboard.accounting')
        ->middleware('role:accounting');

    // POS routes
    Route::middleware(['role:sales|admin', 'ensure.branch'])->group(function () {
        Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
        Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    });

    // Shift/Attendance routes
    Route::middleware(['role:sales|admin', 'ensure.branch'])->group(function () {
        Route::get('/attendance', [ShiftController::class, 'index'])->name('attendance.index');
        Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
        Route::post('/shifts/clock-in', [ShiftController::class, 'clockIn'])->name('shifts.clock-in');
        Route::post('/shifts/clock-out', [ShiftController::class, 'clockOut'])->name('shifts.clock-out');
    });
    
    // Categories routes
    Route::middleware(['role:admin|super_admin', 'ensure.branch'])->group(function () {
        Route::resource('admin/categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);
    });
    
    // Customer routes
    Route::middleware(['role:admin|super_admin|sales', 'ensure.branch'])->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::get('/api/customers/search', [CustomerController::class, 'search'])->name('api.customers.search');
    });
    
    // Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    });

    // Inventory routes
    Route::middleware(['role:admin', 'ensure.branch'])->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::patch('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::post('/inventory/{inventory}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    });

    // Accounting routes
    Route::middleware(['role:accounting|admin', 'ensure.branch'])->group(function () {
        Route::get('/accounting/expenses', [AccountingController::class, 'expenses'])->name('accounting.expenses');
        Route::post('/accounting/expenses', [AccountingController::class, 'createExpense'])->name('accounting.expenses.create');
        Route::get('/accounting/export/sales', [AccountingController::class, 'exportSalesReport'])->name('accounting.export.sales');
        Route::get('/accounting/export/expenses', [AccountingController::class, 'exportExpensesReport'])->name('accounting.export.expenses');
    });

    // Order Management routes
    Route::middleware(['role:admin|super_admin|accounting'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Order deletion (admin and super_admin only)
    Route::middleware(['role:admin|super_admin'])->group(function () {
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    // Receipt routes
    Route::middleware(['role:admin|super_admin|accounting|sales'])->group(function () {
        Route::get('/receipts/{receipt}', [ReceiptController::class, 'show'])->name('receipts.show');
        Route::get('/receipts/{receipt}/download', [ReceiptController::class, 'download'])->name('receipts.download');
    });

    // Reports routes
    Route::middleware(['role:admin|super_admin|accounting'])->group(function () {
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');
    });

    // Business Management (Super Admin only)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::resource('businesses', BusinessController::class);
    });

    // Branch Management (Super Admin only)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::resource('branches', BranchController::class)->except(['show']);
        Route::get('/branches/{branch}/details', [BranchController::class, 'show'])->name('branches.show');
    });

    // Admin routes
    Route::middleware(['role:admin|super_admin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
        Route::post('/admin/products', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');
        
        // User role and permission management
        Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.users.assign-role');
        Route::post('/admin/users/{user}/assign-permission', [AdminController::class, 'assignPermission'])->name('admin.users.assign-permission');
        Route::post('/admin/users/{user}/revoke-permission', [AdminController::class, 'revokePermission'])->name('admin.users.revoke-permission');
        
        // Roles management
        Route::resource('admin/roles', RoleController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'show' => 'admin.roles.show',
            'edit' => 'admin.roles.edit',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ]);
        
        // Permissions management
        Route::resource('admin/permissions', PermissionController::class)->names([
            'index' => 'admin.permissions.index',
            'create' => 'admin.permissions.create',
            'store' => 'admin.permissions.store',
            'show' => 'admin.permissions.show',
            'edit' => 'admin.permissions.edit',
            'update' => 'admin.permissions.update',
            'destroy' => 'admin.permissions.destroy',
        ]);
    });

    // Export routes
    Route::middleware(['role:accounting|admin'])->group(function () {
        Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');
        Route::get('/exports/{export}/download', [ExportController::class, 'download'])->name('exports.download');
    });


    // Branch selection (for users without branch)
    Route::get('/branches/select', function () {
        $user = auth()->user();
        $branches = \App\Models\Branch::all();
        return view('branches.select', compact('branches'));
    })->name('branches.select');

    Route::post('/branches/select', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        $user = auth()->user();
        $user->update(['branch_id' => $request->branch_id]);

        return redirect()->route('dashboard')->with('success', 'Branch selected successfully');
    })->name('branches.store');
});

// Product image route (for shared hosting compatibility) - must be outside auth middleware
Route::get('/products/{product}/image', function ($productId) {
    try {
        $product = \App\Models\Product::findOrFail($productId);
        
        if (!$product->image) {
            abort(404, 'Product image not found');
        }
        
        // Try multiple possible paths
        $imagePath = null;
        
        // First, try storage/app/public (standard Laravel location)
        $storagePath = storage_path('app/public/' . $product->image);
        if (file_exists($storagePath) && is_file($storagePath)) {
            $imagePath = $storagePath;
        }
        
        // If not found, try public/storage (symbolic link location)
        if (!$imagePath) {
            $publicPath = public_path('storage/' . $product->image);
            if (file_exists($publicPath) && is_file($publicPath)) {
                $imagePath = $publicPath;
            }
        }
        
        if (!$imagePath || !file_exists($imagePath)) {
            // Log for debugging
            \Log::warning('Product image not found', [
                'product_id' => $product->id,
                'image_path' => $product->image,
                'storage_path' => $storagePath,
                'public_path' => $publicPath ?? null,
            ]);
            
            abort(404, 'Image file not found: ' . $product->image);
        }
        
        // Get file extension for proper content type
        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];
        
        $mimeType = $mimeTypes[$extension] ?? 'image/jpeg';
        
        return response()->file($imagePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    } catch (\Exception $e) {
        \Log::error('Error serving product image', [
            'product_id' => $productId ?? null,
            'error' => $e->getMessage(),
        ]);
        abort(404, 'Error loading image');
    }
})->name('product.image');

require __DIR__.'/auth.php';

