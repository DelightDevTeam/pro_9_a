<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArchiveOldWagers extends Command
{
    protected $signature = 'archive:old-wagers';

    protected $description = 'Archive and delete old wagers in chunks';

    public function handle()
    {
        // Define the date range from 20 days ago starting from the beginning of the day to now
        $startOfDay = now()->subDays(1)->startOfDay();  // Start of the day 20 days ago
        $endOfDay = now();  // Current time

        try {
            // Process wagers in chunks within the date range
            DB::table('wagers')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->orderBy('id')
                ->chunk(1000, function ($oldWagers) {
                    if ($oldWagers->isEmpty()) {
                        $this->info('No wagers found to archive.');

                        return;
                    }

                    $this->info(count($oldWagers).' wagers found for archiving.');

                    DB::transaction(function () use ($oldWagers) {
                        // Insert old wagers into the wager_archives table in smaller batches
                        $oldWagers->chunk(100)->each(function ($wagerBatch) {
                            try {
                                DB::table('wager_backups')->insert(
                                    $wagerBatch->map(function ($wager) {
                                        return [
                                            'user_id' => $wager->user_id,
                                            'seamless_wager_id' => $wager->seamless_wager_id,
                                            'status' => $wager->status,
                                            'created_at' => $wager->created_at,
                                            'updated_at' => $wager->updated_at,
                                        ];
                                    })->toArray()
                                );
                            } catch (\Exception $e) {
                                Log::error('Error inserting wagers into wager_archives: '.$e->getMessage());
                                $this->error('Failed to insert some wagers. Check logs for details.');
                            }
                        });

                        // Disable foreign key checks
                        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                        // Fetch the IDs of the old wagers
                        $wagerIds = $oldWagers->pluck('id')->toArray();

                        // Delete old wagers from the wagers table
                        try {
                            DB::table('wagers')->whereIn('id', $wagerIds)->delete();
                        } catch (\Exception $e) {
                            Log::error('Error deleting old wagers: '.$e->getMessage());
                            $this->error('Failed to delete some old wagers. Check logs for details.');
                        }

                        // Re-enable foreign key checks
                        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                    });

                    $this->info(count($oldWagers).' wagers have been archived and deleted successfully.');
                });

            $this->info('Wager archiving complete.');
        } catch (\Exception $e) {
            // Log the error and display a failure message
            Log::error('Error archiving wagers: '.$e->getMessage());
            $this->error('An error occurred while archiving wagers. Check logs for details.');
        }
    }

    // public function handle()
    // {
    //     // Define the date threshold (e.g., wagers older than 30 days)
    //     $thresholdDate = now()->subDays(20);

    //     try {
    //         // Process wagers in chunks
    //         DB::table('wagers')
    //             ->where('created_at', '<', $thresholdDate)
    //             ->orderBy('id')
    //             ->chunk(1000, function ($oldWagers) {
    //                 if ($oldWagers->isEmpty()) {
    //                     $this->info('No wagers found to archive.');

    //                     return;
    //                 }

    //                 $this->info(count($oldWagers).' wagers found for archiving.');

    //                 DB::transaction(function () use ($oldWagers) {
    //                     // Insert old wagers into the wager_archives table in smaller batches
    //                     $oldWagers->chunk(100)->each(function ($wagerBatch) {
    //                         try {
    //                             DB::table('wager_backups')->insert(
    //                                 $wagerBatch->map(function ($wager) {
    //                                     return [
    //                                         'user_id' => $wager->user_id,
    //                                         'seamless_wager_id' => $wager->seamless_wager_id,
    //                                         'status' => $wager->status,
    //                                         'created_at' => $wager->created_at,
    //                                         'updated_at' => $wager->updated_at,
    //                                     ];
    //                                 })->toArray()
    //                             );
    //                         } catch (\Exception $e) {
    //                             Log::error('Error inserting wagers into wager_archives: '.$e->getMessage());
    //                             $this->error('Failed to insert some wagers. Check logs for details.');
    //                         }
    //                     });

    //                     // Disable foreign key checks
    //                     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    //                     // Fetch the IDs of the old wagers
    //                     $wagerIds = $oldWagers->pluck('id')->toArray();

    //                     // Delete old wagers from the wagers table
    //                     try {
    //                         DB::table('wagers')->whereIn('id', $wagerIds)->delete();
    //                     } catch (\Exception $e) {
    //                         Log::error('Error deleting old wagers: '.$e->getMessage());
    //                         $this->error('Failed to delete some old wagers. Check logs for details.');
    //                     }

    //                     // Re-enable foreign key checks
    //                     DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    //                 });

    //                 $this->info(count($oldWagers).' wagers have been archived and deleted successfully.');
    //             });

    //         $this->info('Wager archiving complete.');
    //     } catch (\Exception $e) {
    //         // Log the error and display a failure message
    //         Log::error('Error archiving wagers: '.$e->getMessage());
    //         $this->error('An error occurred while archiving wagers. Check logs for details.');
    //     }
    // }

    //     public function handle()
    // {
    //     // Define the date threshold (e.g., wagers older than 30 days)
    //     $thresholdDate = now()->subDays(20);

    //     try {
    //         // Process wagers in chunks
    //         DB::table('wagers')
    //             ->where('created_at', '<', $thresholdDate)
    //             ->orderBy('id')
    //             ->chunk(1000, function ($oldWagers) {
    //                 if ($oldWagers->isEmpty()) {
    //                     $this->info('No wagers found to archive.');
    //                     return;
    //                 }

    //                 $this->info(count($oldWagers) . ' wagers found for archiving.');

    //                 DB::transaction(function () use ($oldWagers) {
    //                     // Insert old wagers into the wager_archives table with explicit column mapping
    //                     DB::table('wager_archives')->insert(
    //                         $oldWagers->map(function ($wager) {
    //                             return [
    //                                 'user_id' => $wager->user_id,
    //                                 'seamless_wager_id' => $wager->seamless_wager_id,
    //                                 'status' => $wager->status,
    //                                 'created_at' => $wager->created_at,
    //                                 'updated_at' => $wager->updated_at,
    //                             ];
    //                         })->toArray()
    //                     );

    //                     // Disable foreign key checks
    //                     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    //                     // Fetch the IDs of the old wagers
    //                     $wagerIds = $oldWagers->pluck('id')->toArray();

    //                     // Delete old wagers from the wagers table
    //                     DB::table('wagers')->whereIn('id', $wagerIds)->delete();

    //                     // Re-enable foreign key checks
    //                     DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    //                 });

    //                 $this->info(count($oldWagers) . ' wagers have been archived and deleted successfully.');
    //             });

    //         $this->info('Wager archiving complete.');
    //     } catch (\Exception $e) {
    //         // Log the error and display a failure message
    //         Log::error('Error archiving wagers: ' . $e->getMessage());
    //         $this->error('An error occurred while archiving wagers. Check logs for details.');
    //     }
    // }

    //     public function handle()
    // {
    //     // Define the date threshold (e.g., wagers older than 30 days)
    //     $thresholdDate = now()->subDays(20);

    //     // Process wagers in chunks
    //     DB::table('wagers')
    //         ->where('created_at', '<', $thresholdDate)
    //         ->orderBy('id')
    //         ->chunk(1000, function ($oldWagers) {
    //             if ($oldWagers->isEmpty()) {
    //                 $this->info('No wagers found to archive.');
    //                 return;
    //             }

    //             $this->info(count($oldWagers) . ' wagers found for archiving.');

    //             DB::transaction(function () use ($oldWagers) {
    //                 // Insert old wagers into the wager_archives table with explicit column mapping
    //                 DB::table('wager_archives')->insert(
    //                     $oldWagers->map(function ($wager) {
    //                         return [
    //                             'user_id' => $wager->user_id,
    //                             'seamless_wager_id' => $wager->seamless_wager_id,
    //                             'status' => $wager->status,
    //                             'created_at' => $wager->created_at,
    //                             'updated_at' => $wager->updated_at,
    //                         ];
    //                     })->toArray()
    //                 );

    //                 // Delete old wagers from the wagers table
    //                 $wagerIds = $oldWagers->pluck('id')->toArray();
    //                 DB::table('wagers')->whereIn('id', $wagerIds)->delete();
    //             });

    //             $this->info(count($oldWagers) . ' wagers have been archived and deleted successfully.');
    //         });

    //     $this->info('Wager archiving complete.');
    // }

    // public function handle()
    // {
    //     // Define the date threshold (e.g., wagers older than 30 days)
    //     $thresholdDate = now()->subDays(30);

    //     // Process wagers in chunks
    //     DB::table('wagers')
    //         ->where('created_at', '<', $thresholdDate)
    //         ->orderBy('id')
    //         ->chunk(1000, function ($oldWagers) {
    //             if ($oldWagers->isEmpty()) {
    //                 $this->info('No wagers found to archive.');
    //                 return;
    //             }

    //             $this->info(count($oldWagers) . ' wagers found for archiving.');

    //             DB::transaction(function () use ($oldWagers) {
    //                 // Insert old wagers into the wager_archives table
    //                 DB::table('wager_archives')->insert(
    //                     $oldWagers->map(function ($wager) {
    //                         return (array) $wager; // Convert object to associative array
    //                     })->toArray()
    //                 );

    //                 // Delete old wagers from the wagers table
    //                 $wagerIds = $oldWagers->pluck('id')->toArray();
    //                 DB::table('wagers')->whereIn('id', $wagerIds)->delete();
    //             });

    //             $this->info(count($oldWagers) . ' wagers have been archived and deleted successfully.');
    //         });

    //     $this->info('Wager archiving complete.');
    // }
}
