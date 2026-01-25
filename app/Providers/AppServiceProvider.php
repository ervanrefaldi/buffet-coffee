<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // PENTING: Fix untuk Shared Hosting (cPanel)
        // Mengecek apakah folder public_html ada di luar folder project
        if (file_exists(base_path('../public_html'))) {
            $this->app->bind('path.public', function() {
                return base_path('../public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production') || request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
