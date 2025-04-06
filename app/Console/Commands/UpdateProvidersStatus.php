<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateProvidersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-providers-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing providers with a default status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating provider status...');

        // Get all providers
        $providers = User::where('role', 'PROVIDER')
            ->whereNull('status')
            ->get();

        $count = $providers->count();
        $this->info("Found {$count} providers without status");

        foreach ($providers as $provider) {
            $provider->status = 'active';
            $provider->save();
        }

        $this->info('Provider status updated successfully');

        return self::SUCCESS;
    }
}
