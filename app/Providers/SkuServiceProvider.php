<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Sku;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class SkuServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $gate->define('get-sku', function ($user) {
            return ((rand(0, 1) === 0) ? true : false);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Helpers\Contracts\SkuContract', function(){

            return new Sku();

        });
    }

    public function provides()
    {
        return ['App\Helpers\Contracts\SkuContract'];
    }

}
