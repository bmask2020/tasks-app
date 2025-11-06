<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\tasks;
use App\Observers\TaskObserver;

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
        tasks::observe(TaskObserver::class);
    }
}
