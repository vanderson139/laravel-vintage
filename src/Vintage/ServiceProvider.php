<?php namespace Vintage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/vintage.php' => config_path('vintage.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../../routes.php');
    }
}
