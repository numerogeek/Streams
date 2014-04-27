<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\ExtensionManager;

class ExtensionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.extensions',
            function () {
                return new ExtensionManager;
            }
        );

        $this->app['streams.extensions']->register($this->app);
    }
}
