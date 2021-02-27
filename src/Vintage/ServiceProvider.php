<?php namespace Vintage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
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

        $this->app->singleton('vintage', function ($app) {
            return new Factory($app);
        });

        $this->registerIncludePath();
        $this->registerMiddlewares();
    }

    private function registerIncludePath(): void {
        $include_path = base_path(config('vintage.folder_name'));
        set_include_path(get_include_path() . PATH_SEPARATOR . $include_path);
    }

    private function registerMiddlewares(): void {
        $router = $this->app['router'];

        foreach (config('vintage.middlewares', []) as $midleware) {
            if (class_exists($midleware)) {
                $router->pushMiddlewareToGroup('vintage', $midleware);
            }
        }
    }
}
