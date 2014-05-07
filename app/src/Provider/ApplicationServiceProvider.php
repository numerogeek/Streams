<?php namespace Streams\Provider;

use Streams\Support\Application;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.application',
            function () {
                return new Application;
            }
        );
    }
}
