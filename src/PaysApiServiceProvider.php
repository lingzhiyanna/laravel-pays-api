<?php

namespace DavidNineRoc\Payment;

use Illuminate\Support\ServiceProvider;

class PaysApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
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
     */
    public function register()
    {
        $closurePay = function () {
            return (new PaysApi())->setOptions(
                config('paysapi')
            );
        };

        $this->app->bind(PaysApi::class, $closurePay);
        $this->app->bind('paysapi', $closurePay);
    }
}
