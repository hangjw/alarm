<?php

namespace Hangjw\Alarm;

use Illuminate\Support\ServiceProvider;

class AlarmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__ . '/config/alarm.php' => config_path('alarm.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AlarmManager::class, function ($app) {

            return new AlarmManager($app->make('config'), $app->make('request'));
        });
    }
}
