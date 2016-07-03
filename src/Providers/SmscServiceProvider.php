<?php

namespace CoderStudio\Smsc\Providers;

use CoderStudio\Smsc\Smsc;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SmscServiceProvider extends ServiceProvider
{
    /**
     * YandexPdd the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/smsc.php' => config_path('smsc.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/smsc.php', 'smsc');

        App::bind('smsc', function () {
            return new Smsc;
        });
    }
}
