<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetupSharedHosting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:shared-hosting 
                            {--force : Force setup even if directories exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup storage directories and permissions for shared hosting';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Setting up shared hosting environment...');
        $this->newLine();

        // Create necessary directories
        $directories = [
            storage_path('app/public/products'),
            storage_path('app/receipts'),
            storage_path('app/exports'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
        ];

        $this->info('Creating storage directories...');
        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->line("  ✓ Created: {$directory}");
            } else {
                $this->line("  - Exists: {$directory}");
            }
        }

        $this->newLine();

        // Create public/storage directory if it doesn't exist
        $publicStorage = public_path('storage');
        if (!File::exists($publicStorage)) {
            $this->info('Creating public/storage directory...');
            File::makeDirectory($publicStorage, 0755, true);
            $this->line("  ✓ Created: {$publicStorage}");
            
            // Create .gitkeep to ensure directory is tracked
            File::put($publicStorage . '/.gitkeep', '');
        } else {
            $this->line("  - Public storage exists: {$publicStorage}");
        }

        $this->newLine();

        // Check if symbolic link exists
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        if (!File::exists($linkPath) || !is_link($linkPath)) {
            $this->warn('Symbolic link not found. For shared hosting:');
            $this->line('  1. If symbolic links are supported, run: php artisan storage:link');
            $this->line('  2. If not, manually copy files from storage/app/public/ to public/storage/');
        } else {
            $this->info('  ✓ Symbolic link exists');
        }

        $this->newLine();

        // Set permissions (informational only - actual permissions depend on server)
        $this->info('Recommended file permissions:');
        $this->line('  Directories: 755');
        $this->line('  Files: 644');
        $this->line('  Storage directories: 755');
        $this->line('  Bootstrap cache: 755');

        $this->newLine();
        $this->info('✓ Shared hosting setup complete!');
        $this->newLine();
        $this->comment('Next steps:');
        $this->line('  1. Configure .env file with your database and mail settings');
        $this->line('  2. Run: php artisan migrate --force');
        $this->line('  3. Run: php artisan config:cache');
        $this->line('  4. Test product image uploads');
        $this->line('  5. Test receipt generation');

        return Command::SUCCESS;
    }
}

