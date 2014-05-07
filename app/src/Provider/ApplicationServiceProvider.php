<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Support\Application;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplication();
    }

    /**
     * Register the application support class
     */
    protected function registerApplication()
    {
        $this->app->singleton(
            'streams.application',
            function () {
                return new Application;
            }
        );
    }
}
