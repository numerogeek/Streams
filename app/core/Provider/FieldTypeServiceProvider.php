<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Addon\FieldTypeManager;

class FieldTypeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'streams.fieldtypes',
            function () {
                return new FieldTypeManager;
            }
        );

        $this->app['streams.fieldtypes']->register($this->app);
    }
}
