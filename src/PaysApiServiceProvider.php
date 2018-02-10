<?php

namespace DavidNineRoc\Payment;

use Illuminate\Support\ServiceProvider;

class PaysApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes(
            [
                __DIR__.'/../config/paysapi.php' => config_path('paysapi.php'),
            ],
            'config'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('paysapi', function () {
            return new PaysApi();
        });
    }
}
