<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Provider\Profile;
use App\Livewire\Provider\EditProfile;

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
    }
}
