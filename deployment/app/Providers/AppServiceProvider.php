<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Provider\Profile;
use App\Livewire\Provider\EditProfile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Livewire Components
        Livewire::component('provider.profile', Profile::class);
        Livewire::component('provider.edit-profile', EditProfile::class);

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Fix Vite manifest path in production
        if (config('app.env') === 'production') {
            // Set the correct manifest path for the subdirectory installation
            Vite::useManifestFilename('/home/eastbizzcom/public_html/ofys/public/build/manifest.json');
        }
    }
}
