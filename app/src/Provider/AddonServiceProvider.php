<?php namespace Streams\Provider;

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
        $this->registerBlocks();
        $this->registerExtensions();
        $this->registerFieldTypes();
        $this->registerModules();
        $this->registerTags();
        $this->registerThemes();
    }

    /**
     * Register Blocks
     */
    public function registerBlocks()
    {
        $this->app->singleton(
            'streams.blocks',
            function () {
                return new BlockManager;
            }
        );

        $this->app['streams.blocks']->register();
    }

    /**
     * Register Extensions
     */
    public function registerExtensions()
    {
        $this->app->singleton(
            'streams.extensions',
            function () {
                return new ExtensionManager;
            }
        );

        $this->app['streams.extensions']->register();
    }

    /**
     * Register field types
     */
    public function registerFieldTypes()
    {
        $this->app->singleton(
            'streams.fieldtypes',
            function () {
                return new FieldTypeManager;
            }
        );

        $this->app['streams.fieldtypes']->register();
    }

    /**
     * Register Modules
     */
    public function registerModules()
    {
        $this->app->singleton(
            'streams.modules',
            function () {
                return new ModuleManager;
            }
        );

        $this->app['streams.modules']->register();
    }

    /**
     * Register Tags
     */
    public function registerTags()
    {
        $this->app->singleton(
            'streams.tags',
            function () {
                return new TagManager;
            }
        );

        $this->app['streams.tags']->register();
    }

    /**
     * Register Themes
     */
    public function registerThemes()
    {
        $this->app->singleton(
            'streams.themes',
            function () {
                return new ThemeManager;
            }
        );

        $this->app['streams.themes']->register();
    }

}