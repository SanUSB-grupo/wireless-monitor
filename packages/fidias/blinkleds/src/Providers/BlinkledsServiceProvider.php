<?php

namespace Fidias\Blinkleds\Providers;

use Illuminate\Support\ServiceProvider;

class BlinkledsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'blinkleds');

        $this->publishes([
            __DIR__ . '/../storage/json-schema' => storage_path('app/json-schema')
        ], 'storage');

        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../migrations/insert_blinkleds_monitor.php' => database_path('/migrations/' . $timestamp . '_insert_blinkleds_monitor.php'),
        ], 'database');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
