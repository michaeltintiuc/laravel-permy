<?php
namespace MichaelT\Permy;

use Illuminate\Support\ServiceProvider;

/**
 * Permy ServiceProvider
 *
 * @package michaeltintiuc/laravel-permy
 * @author Michael Tintiuc
 **/
class PermyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // checking directly through $this->app::VERSION fails in php ~5.5.14
        $app = $this->app;

        if (version_compare($app::VERSION, '5.0.0') >= 0) {
            $path = __DIR__.'/../..';

            $this->loadTranslationsFrom("$path/lang", 'laravel-permy');
            $this->mergeConfigFrom("$path/config/config.php", 'laravel-permy');

            $this->publishes(["$path/config/config.php" => config_path('laravel-permy.php')], 'config');
            $this->publishes(["$path/migrations/" => database_path('/migrations')], 'migrations');
            $this->publishes(["$path/lang/" => resource_path('lang/vendor/laravel-permy')], 'translations');
        } else {
            $this->package('michaeltintiuc/laravel-permy');
        }

        if ($this->app->runningInConsole()) {
            $this->commands(['MichaelT\Permy\Commands\Can']);
        }

        if (class_exists('Blade')) {
            if (version_compare($app::VERSION, '5.1.0') >= 0) {
                new BladeDirectives();
            } else {
                new LegacyBladeDirectives();
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('permy', function () {
            return new PermyHandler;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['permy'];
    }
}
