<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\ModuleManager;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.modules',
            function () {
                return new ModuleManager;
            }
        );

        $modules = $this->app->make('streams.modules');
        $modules->register($this->app);
    }
}
