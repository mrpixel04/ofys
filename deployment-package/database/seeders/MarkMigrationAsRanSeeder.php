<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkMigrationAsRanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the migration is already marked as ran
        $migrationExists = DB::table('migrations')
            ->where('migration', '2025_03_15_082135_create_shop_infos_table')
            ->exists();

        if (!$migrationExists) {
            // Get the latest batch number
            $latestBatch = DB::table('migrations')->max('batch') ?? 0;

            // Insert the migration as completed
            DB::table('migrations')->insert([
                'migration' => '2025_03_15_082135_create_shop_infos_table',
                'batch' => $latestBatch + 1,
            ]);

            $this->command->info('Migration 2025_03_15_082135_create_shop_infos_table marked as ran.');
        } else {
            $this->command->info('Migration 2025_03_15_082135_create_shop_infos_table is already marked as ran.');
        }
    }
}
