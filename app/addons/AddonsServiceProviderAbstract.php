<?php namespace App\Addons;

use Illuminate\Support\ServiceProvider;

abstract class AddonsServiceProviderAbstract extends ServiceProvider
{
    /**
     * Type
     *
     * @var string
     */
    protected $type = 'modules';

    /**
     * Boot
     */
    public function boot()
    {
        if ($addon = $this->getAddon(func_get_args())) {
            $this->package('app/' . $this->type . '/' . $addon, $addon, app_path() . '/addons/' . $this->type . '/' . $addon);
        }
    }

    /**
     * Register Addon Type
     */
    public function register()
    {
        if ($addon = $this->getAddon(func_get_args())) {
            $this->app['config']->package(
                'app/' . $this->type . '/' . $addon,
                app_path() . '/addons/' . $this->type . '/' . $addon . '/config'
            );

            // Add routes
            $routes = app_path() . '/addons/' . $this->type . '/' . $addon . '/config/routes.php';

            if (file_exists($routes)) {
                require $routes;
            }
        }
    }

    /**
     * Get addon
     *
     * @param $arguments
     * @return null
     */
    public function getAddon($arguments)
    {
        return (isset($arguments[0]) and is_string($arguments[0])) ? $arguments[0] : null;
    }
}