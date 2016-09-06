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
        require __DIR__ . '/../Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/../views', 'photoresistor');
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
