<?php namespace Streams\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Support\Application;

class ApplicationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplication();

        if (\Config::get('debug')) {
            if (!\Application::isInstalled()) {
                if (\Request::segment(1) !== 'installer') {
                    header('Location: installer');exit;
                }
            }
        } elseif (\Request::segment(1) !== 'installer') {
            \Application::locate();
        }
    }

    /**
     * Register the application support class
     */
    protected function registerApplication()
    {
        $this->app->bind(
            'streams.application',
            function () {
                return new Application;
            }
        );
    }

}