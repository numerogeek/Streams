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
        parent::boot();

        $this->loader = new ClassLoader();
    }

    /**
     * Register Addon Type
     */
    public function register()
    {
        if ($addon = $this->getAddon(func_get_args())) {

            // Register PSR class directories
            foreach ($addon->getAutoloadDirectories() as $directory => $suffix) {
                $this->loader->addPsr4(
                    'Addon\Module\\' . Str::studly($addon->slug) . '\\' . $suffix . '\\',
                    $addon->path . '/' . $directory
                );
            }

            $this->loader->register();

            // Add view namespace
            \View::addNamespace(get_class($addon), $addon->path.'/views');

            // Add language namespace
            \Lang::addNamespace(get_class($addon), $addon->path.'/lang');

            // Add routes
            $routes = $addon->path . '/config/routes.php';

            if (file_exists($routes)) {
                require $routes;
            }

            return true;
        }

        return false;
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