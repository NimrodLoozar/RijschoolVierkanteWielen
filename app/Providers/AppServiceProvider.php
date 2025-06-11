<?php
// Laravel project: app\View\Components/ThemeToggle.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
    // In app/Providers/AppServiceProvider.php
    public function boot()
    {
        Blade::component('theme-toggle', \App\View\Components\ThemeToggle::class);
    }
}
