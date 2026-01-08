<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

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
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verify Your OFYS Account')
                ->view('emails.auth.verify-email', [
                    'name' => $notifiable->name ?? 'Explorer',
                    'actionUrl' => $url,
                    'supportEmail' => config('mail.from.address'),
                ]);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Reset Your OFYS Password')
                ->view('emails.auth.reset-password', [
                    'name' => $notifiable->name ?? 'Explorer',
                    'actionUrl' => $resetUrl,
                    'supportEmail' => config('mail.from.address'),
                ]);
        });

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            // Guardrails: surface misconfiguration loudly
            if (config('app.debug')) {
                Log::critical('APP_DEBUG is enabled in production. Disable debug and clear caches.');
            }

            if (!config('session.secure')) {
                Log::critical('SESSION_SECURE_COOKIE is false in production. Enable secure cookies.');
            }
        }

        // Fix Vite manifest path in production
        if (config('app.env') === 'production') {
            // Set the correct manifest path for the subdirectory installation
            Vite::useManifestFilename('/home/eastbizzcom/public_html/ofys/public/build/manifest.json');
        }
    }
}
