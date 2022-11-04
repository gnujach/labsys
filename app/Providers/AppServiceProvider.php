<?php

namespace App\Providers;

use BaconQrCode\Common\Mode;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            $class = get_class($model);
            info("Lazy load of [{$relation}] on [{$class}] ");
        });
    }
}
