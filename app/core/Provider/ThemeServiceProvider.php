<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\ThemeManager;

class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.themes',
            function () {
                return new ThemeManager;
            }
        );

        $this->app['streams.themes']->register($this->app);
    }
}