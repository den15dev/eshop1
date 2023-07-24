<?php

namespace App\Providers;

use App\Services\Site\CommonService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Services\Site\InitializationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        bcscale(2);

        (new InitializationService())->check();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function() use (&$query_counter) {
            CommonService::$db_query_num++;
        });

        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
    }
}
