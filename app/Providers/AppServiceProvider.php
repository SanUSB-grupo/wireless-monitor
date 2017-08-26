<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::directive('isActive', function ($route) {
            return "<?php echo URL::current() == URL::to({$route}) ? 'active' : ''; ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
