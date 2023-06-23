<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\HeaderComposer;
use App\View\Composers\AdminNavComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Passing data for header menus
        View::composer('layout.includes.header.header', HeaderComposer::class);

        // Passing data for admin panel's navigation menu
        View::composer('admin.includes.menu', AdminNavComposer::class);
    }
}
