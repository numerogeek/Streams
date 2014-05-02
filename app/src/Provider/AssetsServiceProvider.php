<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Html\AssetsHtml;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
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