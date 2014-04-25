<?php namespace App\Addon;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

abstract class AddonServiceProviderAbstract extends ServiceProvider
{
    /**
     * The manager class to use.
     *
     * @var null
     */
    protected $managerClass = null;

    /**
     * Inject dependencies and load all modules
     */
    public function boot()
    {
        parent::boot();

        // Inject composers class loader and our manager class
        $this->loader  = new ClassLoader();
        $this->manager = new $this->managerClass;

        // Load and register all addons
        foreach ($this->manager->getAllAddons() as $addon) {
            self::register($addon);
        }
    }

    /**
     * Register an addon's path and structure.
     */
    public function register()
    {
        // All we are going to do here is add namespaces,
        // include dependent files and register PSR-4 paths.
        if ($addon = $this->getAddon(func_get_args())) {

            // Register src directory
            if (is_dir($addon->path . '/src')) {
                $this->loader->addPsr4(
                    'Addon\Module\\' . Str::studly($addon->slug) . '\\',
                    $addon->path . '/src'
                );
            }

            // Register controllers directory
            if (is_dir($addon->path . '/controllers')) {
                $this->loader->addPsr4(
                    'Addon\Module\\' . Str::studly($addon->slug) . '\Controller\\',
                    $addon->path . '/controllers'
                );
            }

            // Register paths added above
            $this->loader->register();

            // Add views namespace
            if (is_dir($addon->path . '/views')) {
                \View::addNamespace(get_class($addon), $addon->path . '/views');
            }

            // Add lang namespace
            if (is_dir($addon->path . '/lang')) {
                \Lang::addNamespace(get_class($addon), $addon->path . '/lang');
            }

            // Add config namespace
            if (is_dir($addon->path . '/config')) {
                \Config::addNamespace(get_class($addon), $addon->path . '/config');
            }

            // Add routes file
            if (is_file($addon->path . '/routes.php')) {
                require $addon->path . '/routes.php';
            }
        }
    }

    /**
     * Get and verify addon object passed to the service provider.
     *
     * @param $arguments
     * @return null
     */
    public function getAddon($arguments)
    {
        return (isset($arguments[0]) and is_object($arguments[0])) ? $arguments[0] : null;
    }
}