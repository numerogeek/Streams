<?php namespace Streams\Provider;


use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Streams\Addon\BlockManager;
use Streams\Addon\ExtensionManager;
use Streams\Addon\FieldTypeManager;
use Streams\Addon\ModuleManager;
use Streams\Addon\TagManager;
use Streams\Addon\ThemeManager;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     */
    public function register()
    {
        $loader = new ClassLoader;

        $this->registerBlocks($loader);
        $this->registerExtensions($loader);
        $this->registerFieldTypes($loader);
        $this->registerModules($loader);
        $this->registerTags($loader);
        $this->registerThemes($loader);
    }

    /**
     * Register Blocks
     */
    public function registerBlocks($loader)
    {
        $this->app->singleton(
            'streams.blocks',
            function () use ($loader) {
                return new BlockManager($loader);
            }
        );

        $this->app['streams.blocks']->register();
    }

    /**
     * Register Extensions
     */
    public function registerExtensions($loader)
    {
        $this->app->singleton(
            'streams.extensions',
            function () use ($loader) {
                return new ExtensionManager($loader);
            }
        );

        $this->app['streams.extensions']->register();
    }

    /**
     * Register field types
     */
    public function registerFieldTypes($loader)
    {
        $this->app->singleton(
            'streams.fieldtypes',
            function () use ($loader) {
                return new FieldTypeManager($loader);
            }
        );

        $this->app['streams.fieldtypes']->register();
    }

    /**
     * Register Modules
     */
    public function registerModules($loader)
    {
        $this->app->singleton(
            'streams.modules',
            function () use ($loader) {
                return new ModuleManager($loader);
            }
        );

        $this->app['streams.modules']->register();
    }

    /**
     * Register Tags
     */
    public function registerTags($loader)
    {
        $this->app->singleton(
            'streams.tags',
            function () use ($loader) {
                return new TagManager($loader);
            }
        );

        $this->app['streams.tags']->register();
    }

    /**
     * Register Themes
     */
    public function registerThemes($loader)
    {
        $this->app->singleton(
            'streams.themes',
            function () use ($loader) {
                return new ThemeManager($loader);
            }
        );

        $this->app['streams.themes']->register();
    }
}