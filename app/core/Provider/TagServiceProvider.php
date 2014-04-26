<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\TagManager;

class TagServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.tags',
            function () {
                return new TagManager;
            }
        );

        $this->app['streams.tags']->register($this->app);
    }
}