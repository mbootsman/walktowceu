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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Static site pagination (/news/page/N) is handled by statamic/ssg
     * itself, via the `pagination_route` option in config/statamic/ssg.php.
     */
    public function boot(): void
    {
        //
    }
}
