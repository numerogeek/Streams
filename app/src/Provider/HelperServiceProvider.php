<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Support\EntryHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerEntryHelper();
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
}
