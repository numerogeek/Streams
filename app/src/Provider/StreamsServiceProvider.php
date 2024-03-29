<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Schema\StreamSchemaUtility;

class StreamsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            'streams.schema.utility',
            function () {
                return new StreamSchemaUtility;
            }
        );
    }
}
