<?php namespace Streams\Provider;

use League\Plates\Engine;
use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $engine = new Engine(base_path('app/views'));

        $this->app->singleton(
            'streams.template',
            function () use ($engine) {
                return $engine->makeTemplate();
            }
        );

        $this->app->singleton(
            'streams.template.engine',
            function () use ($engine) {
                return $engine;
            }
        );
    }
}
