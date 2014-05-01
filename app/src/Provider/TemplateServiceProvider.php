<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use League\Plates\Engine;
use League\Plates\Template;

class TemplateServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTemplate();
    }

    /**
     * Register Plates for our template engine.
     */
    protected function registerTemplate()
    {
        $engine = new Engine(base_path('test'));

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