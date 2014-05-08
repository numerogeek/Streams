<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Support\Assets;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.assets',
            function () {
                return new Assets();
            }
        );
    }
}
