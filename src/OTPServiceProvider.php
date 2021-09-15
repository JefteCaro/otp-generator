<?php

namespace Jefte\OTPGenerator;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class OTPServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'otp-generator');

        $this->app->singleton(OTPGenerator::class, function($app) {
            return new OTPGenerator();
        });


        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->configPath() => $this->app->configPath('otp.php'),
            ], 'otp-generator');
        }


        $this->app->bind('otp-generator', function ($app) {
            return $app->make('otp-generator');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(OTPGenerator::class, function($app) {
            return new OTPGenerator();
        });

        $this->publishes(
            [$this->configPath() => config_path('otp.php')],
            'otp-generator');
    }

    /**
     * Set the config path
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/resources/config/otp.php';
    }

}
