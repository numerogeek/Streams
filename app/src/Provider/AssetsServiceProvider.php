<?php namespace Streams\Provider;

use Streams\Html\AssetsHtml;
use Illuminate\Support\ServiceProvider;

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
                return new AssetsHtml();
            }
        );
    }
}
