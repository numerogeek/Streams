<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Helper\CacheHelper;
use Streams\Helper\EntryHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerEntryHelper();
        $this->registerCacheHelper();
    }

    /**
     * Register the entry helper Facade.
     */
    protected function registerEntryHelper()
    {
        $this->app->singleton(
            'entry.helper',
            function () {
                return new EntryHelper;
            }
        );
    }

    /**
     * Register the cache helper Facade.
     */
    protected function registerCacheHelper()
    {
        $this->app->singleton(
            'cache.helper',
            function () {
                return new CacheHelper;
            }
        );
    }
}
