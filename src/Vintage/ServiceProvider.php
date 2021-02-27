<?php namespace Vintage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

final class ServiceProvider extends LaravelServiceProvider
{
    private $config = __DIR__ . '/../../config/vintage.php';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            $this->config => config_path('vintage.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes.php');
    }

    public function register() {
        $this->mergeConfigFrom(
            $this->config, 'vintage'
        );

        $this->registerIncludePath();
        $this->registerMiddlewares();
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    }

    private function registerIncludePath() {
        $include_path = base_path(config('vintage.folder_name'));
        set_include_path(get_include_path() . PATH_SEPARATOR . $include_path);
    }

    private function registerMiddlewares() {
        $router = $this->app['router'];

        foreach (config('vintage.middlewares', []) as $midleware) {
            if (class_exists($midleware)) {
                $router->pushMiddlewareToGroup('vintage', $midleware);
            }
        }
    }
}
