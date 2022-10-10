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
        // 当Dendy配置文件存在时，合并配置文件
        $this->mergeConfigFrom(
            __DIR__.'./config/config.php', 'sendy'
        );
    }

    public function boot()
    {
        // 将配置文件发布到config目录
        $this->publishes([
            __DIR__.'./config/config.php' => config_path('sendy.php')
        ]);
    }
}
