<?php namespace Streams\Provider;

use Illuminate\Support\Str;
use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     */
    public function register()
    {
        $loader = new ClassLoader;

        $this->registerAddons('blocks', $loader);
        $this->registerAddons('extensions', $loader);
        $this->registerAddons('field_types', $loader);
        $this->registerAddons('modules', $loader);
        $this->registerAddons('tags', $loader);
        $this->registerAddons('themes', $loader);
    }

    /**
     * Register addons.
     */
    public function registerAddons($type, $loader)
    {
        $manager = 'Streams\Manager\\' . Str::studly(Str::singular($type)) . 'Manager';

        $this->app->singleton(
            'streams.' . $type,
            function () use ($loader, $manager) {
                return new $manager($loader);
            }
        );

        $this->app['streams.' . $type]->register();
    }

}