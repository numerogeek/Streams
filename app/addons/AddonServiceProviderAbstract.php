<?php namespace App\Addons;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

abstract class AddonServiceProviderAbstract extends ServiceProvider
{
    /**
     * Path
     *
     * @var string
     */
    protected $path = null;

    /**
     * Type
     *
     * @var null
     */
    protected $type = null;

    /**
     * Slug
     *
     * @var null
     */
    protected $slug = null;

    /**
     * Boot
     */
    public function boot()
    {
        $this->loader = new ClassLoader();
    }

    /**
     * Register Addon Type
     */
    public function register()
    {
        if ($addon = $this->getAddon(func_get_args())) {

            // Register the PSR class paths
            foreach ($addon->getAutoloadDirectories() as $directory => $suffix) {
                $this->loader->addPsr4(
                    'Addon\Module\\' . Str::studly($addon->slug) . '\\' . $suffix . '\\',
                    $addon->path . '/' . $directory
                );
            }

            $this->loader->register();

            // Add routes
            $routes = $addon->path . '/config/routes.php';

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
        return (isset($arguments[0])) ? $arguments[0] : null;
    }
}