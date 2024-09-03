<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        //ension
        if ($this->app->environment('local')) {
            DB::listen(function ($query) {
                Log::channel('query')->debug(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            });
        }
    }
}
