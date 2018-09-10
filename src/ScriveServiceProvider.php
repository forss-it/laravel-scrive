<?php
namespace Dialect\Scrive;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
class ScriveServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/scrive.php' => config_path('scrive.php'),
        ], 'config');

    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('scrive', Scrive::class);
        $this->mergeConfigFrom(
            __DIR__.'/../config/scrive.php', 'scrive'
        );
    }
}