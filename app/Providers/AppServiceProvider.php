<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        /* Pagination ka apna view. Laravel ka default Tailwind ke liye
           bana hai; is site par Tailwind nahi hai, isliye uske SVG
           arrow apne asli naap mein aa jaate the aur "Showing 1 to 9"
           do baar dikhta tha. */
        Paginator::defaultView('vendor.pagination.site');
        Paginator::defaultSimpleView('vendor.pagination.site');
    }
}
