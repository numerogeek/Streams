<?php namespace Streams\Addon;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Str;

abstract class AddonManagerAbstract
{
    /**
     * The folder within addons locations to load modules from.
     *
     * @var null
     */
    protected $folder = null;

    /**
     * A runtime cache of registered addons.
     *
     * @var array
     */
    protected $registeredAddons = array();

    public function __construct()
    {
        $this->loader = new ClassLoader;
    }

    /**
     * Register an addon's path and structure.
     */
    public function register($app)
    {
        foreach($this->getAllAddons() as $addon) {

            // All we are going to do here is add namespaces,
            // include dependent files and register PSR-4 paths.
            if ($addon = $this->getAddon($addon)) {

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
                    $app['view']->addNamespace($addon->type . '.' . $addon->slug, $addon->path . '/views');
                }

                // Add lang namespace
                if (is_dir($addon->path . '/lang')) {
                    //$app['translator']->addNamespace($addon->type . '.' . $addon->slug, $addon->path . '/lang');
                }

                // Add config namespace
                if (is_dir($addon->path . '/config')) {
                    $app['config']->addNamespace($addon->type . '.' . $addon->slug, $addon->path . '/config');
                }

                // Load routes file
                if (is_file($addon->path . '/routes.php')) {
                    require_once $addon->path . '/routes.php';
                }

                // Load events file
                if (is_file($addon->path . '/events.php')) {
                    require_once $addon->path . '/events.php';
                }
            }
        }
    }

    /**
     * Get and verify addon object passed to the service provider.
     *
     * @param $arguments
     * @return null
     */
    public function getAddon($addon)
    {
        return (isset($addon) and is_object($addon)) ? $addon : null;
    }

    /**
     * Get all instantiated addons.
     *
     * @return array
     */
    public function getAllAddons()
    {
        foreach ($this->getAllAddonPaths() as $path) {
            if (!isset($this->registeredAddons[basename($path)]) and $addon = $this->make($path)) {
                $this->registeredAddons[$addon->slug] = $addon;
            }
        }

        return $this->registeredAddons;
    }

    /**
     * Make the addon object from it's class file.
     *
     * @param $path
     * @return \stdClass
     */
    public function make($path)
    {
        require $path . '/addon.php';

        $class = Str::studly(basename($path)) . 'Module';

        $addon = new $class;

        $addon->path = $path;
        $addon->slug = basename($path);

        return $addon;
    }

    /**
     * Get all addon paths.
     *
     * @return array
     */
    public function getAllAddonPaths()
    {
        $paths = array();

        //$paths = $paths + $this->getCoreAddonPaths();
        $paths = $paths + $this->getSharedAddonPaths();
        $paths = $paths + $this->getApplicationAddonPaths();

        return $paths;
    }

    /**
     * Get all core addon paths.
     *
     * @return array
     */
    public function getCoreAddonPaths()
    {
        return glob(base_path() . '/core/' . $this->folder . '/*');
    }

    /**
     * Get all shared addon paths.
     *
     * @return array
     */
    public function getSharedAddonPaths()
    {
        return glob(base_path() . '/addons/shared/' . $this->folder . '/*');
    }

    /**
     * Get all application addon paths.
     *
     * @return array
     */
    public function getApplicationAddonPaths()
    {
        return array();
    }
}