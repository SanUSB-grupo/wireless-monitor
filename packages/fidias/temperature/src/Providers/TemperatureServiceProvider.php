<?php

namespace Fidias\Temperature\Providers;

use Illuminate\Support\ServiceProvider;

class TemperatureServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'temperature');

        $this->publishes([
            __DIR__ . '/../storage/json-schema' => storage_path('app/json-schema')
        ], 'storage');

        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../migrations/insert_temperature_monitor.php' => database_path('/migrations/' . $timestamp . '_insert_temperature_monitor.php'),
        ], 'database');
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
