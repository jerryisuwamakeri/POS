<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InventoryAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for low stock items and log alerts';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for low stock items...');

        $lowStockItems = Inventory::with(['product', 'branch'])
            ->whereColumn('qty', '<=', 'min_threshold')
            ->get();

        if ($lowStockItems->isEmpty()) {
            $this->info('No low stock items found.');
            return Command::SUCCESS;
        }

        $this->warn("Found {$lowStockItems->count()} low stock item(s):");

        foreach ($lowStockItems as $inventory) {
            $message = sprintf(
                'Low stock alert: %s at %s - Current: %d, Threshold: %d',
                $inventory->product->name,
                $inventory->branch->name,
                $inventory->qty,
                $inventory->min_threshold
            );

            $this->line($message);
            Log::warning('Low stock alert', [
                'product_id' => $inventory->product_id,
                'branch_id' => $inventory->branch_id,
                'qty' => $inventory->qty,
                'min_threshold' => $inventory->min_threshold,
            ]);
        }

        // TODO: Send email notifications to admins
        // Example:
        // Mail::to($adminEmails)->send(new LowStockAlert($lowStockItems));

        return Command::SUCCESS;
    }
}

