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
        $this->locateOrInstall();
    }

    /**
     * Register the application support class
     */
    protected function registerApplication()
    {
        $this->app->singleton(
            'streams.application',
            function () {
                return new Application;
            }
        );
    }

    /**
     * Locate our app or head to the installer.
     */
    protected function locateOrInstall()
    {
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
     * Setup the our template system.
     */
    protected function setupTemplate()
    {
        $engine = \App::make('streams.template.engine');

        $theme = \Theme::get('streams');

        $engine->addFolder('theme', $theme->path);
    }
}