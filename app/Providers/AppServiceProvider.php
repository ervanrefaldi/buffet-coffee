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
        // PENTING: Universal Fix untuk Shared Hosting & Localhost
        // Menggunakan DOCUMENT_ROOT server untuk menentukan folder public yang sebenarnya
        if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
            $this->app->bind('path.public', function() {
                return $_SERVER['DOCUMENT_ROOT'];
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
