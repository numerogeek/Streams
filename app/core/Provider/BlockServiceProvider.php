<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\BlockManager;

class BlockServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.blocks',
            function () {
                return new BlockManager;
            }
        );

        $this->app['streams.blocks']->register($this->app);
    }
}