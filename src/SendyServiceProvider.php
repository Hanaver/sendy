<?php

namespace SendyApi;

use Illuminate\Support\ServiceProvider;

/**
 * Author Andy
 * Date 2022-09-26
 * Time: 15:11
 */

class SendyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php', 'sendy'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('sendy.php')
        ]);
    }
}
