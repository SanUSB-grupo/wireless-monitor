<?php

namespace Fidias\Photoresistor\Providers;

use Illuminate\Support\ServiceProvider;

class PhotoresistorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'photoresistor');

        $this->publishes([
            __DIR__ . '/../storage/json-schema' => storage_path('app/json-schema')
        ], 'storage');

        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../migrations/insert_photoresistor_monitor.php' => database_path('/migrations/' . $timestamp . '_insert_photoresistor_monitor.php'),
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
