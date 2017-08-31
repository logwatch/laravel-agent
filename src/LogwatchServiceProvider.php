<?php

namespace Logwatch\LaravelAgent;

use Illuminate\Support\ServiceProvider;

class LogwatchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logwatch.php' => config_path('logwatch.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
