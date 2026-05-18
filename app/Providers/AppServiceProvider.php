<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
     * ប្រើ Bootstrap 5 សម្រាប់ Pagination
     */
    public function boot(): void
    {
        // ប្រាប់ Laravel ឱ្យប្រើ custom pagination style
        Paginator::defaultView('vendor.pagination.custom');
    }
}
