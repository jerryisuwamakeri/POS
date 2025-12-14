<?php

namespace App\Console\Commands;

use App\Models\Shift;
use Illuminate\Console\Command;

class BackfillShiftDurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:backfill-durations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill duration_minutes for shifts that are missing it';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Backfilling shift durations...');
        $this->newLine();

        // Find shifts that have clock_out_at but no duration_minutes
        $shifts = Shift::whereNotNull('clock_out_at')
            ->whereNull('duration_minutes')
            ->get();

        if ($shifts->isEmpty()) {
            $this->info('No shifts need duration backfilling.');
            return Command::SUCCESS;
        }

        $this->info("Found {$shifts->count()} shifts to update.");
        $this->newLine();

        $bar = $this->output->createProgressBar($shifts->count());
        $bar->start();

        $updated = 0;
        foreach ($shifts as $shift) {
            $duration = $shift->calculateDuration();
            if ($duration !== null) {
                $shift->update(['duration_minutes' => $duration]);
                $updated++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->newLine();

        $this->info("✓ Successfully updated {$updated} shifts.");

        return Command::SUCCESS;
    }
}

