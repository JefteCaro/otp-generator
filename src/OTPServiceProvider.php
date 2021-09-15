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
        $this->mergeConfigFrom($this->configPath(), 'otp-config');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->configPath() => $this->app->configPath('otp.php'),
            ], 'otp-config');

            $this->publishes([
                $this->resourcePath('migrations/create_otp_tokens_table.php') => database_path(sprintf('migrations/%s_%s',  date('Y_m_d_His'), 'create_otp_tokens_table.php')),
            ], 'otp-migration');
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

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


    protected function resourcePath($path)
    {
        return __DIR__ . '/resources/' . $path;
    }

}
