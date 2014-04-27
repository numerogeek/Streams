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
     * @param $slug
     * @return AddonAbstract
     */
    public function get($slug)
    {
        return isset($this->registeredAddons[$slug]) ? $this->registeredAddons[$slug] : null;
    }

    /**
     * Register an addon's path and structure.
     */
    public function register($app)
    {
        $type = null;
        foreach ($this->getAllAddonPaths() as $path) {

            $slug = basename($path);

            $type = strtolower(Str::singular(dirname($path)));

            // All we are going to do here is add namespaces,
            // include dependent files and register PSR-4 paths.

            // Register src directory
            $this->loader->addPsr4(
                $this->getNamespace($type, $slug) . '\\',
                $path . '/src'
            );

            // Register controllers directory
            $this->loader->addPsr4(
                $this->getNamespace($type, $slug) . '\\Controller\\',
                $path . '/controllers'
            );

            // Register paths added above
            $this->loader->register();

            // Add views namespace
            if (is_dir($path . '/views')) {
                $app['view']->addNamespace($type . '.' . $slug, $path . '/views');
            }

            // Add lang namespace
            if (is_dir($path . '/lang')) {
                //$app['translator']->addNamespace($type . '.' . $slug, $path . '/lang');
            }

            // Add config namespace
            if (is_dir($path . '/config')) {
                $app['config']->addNamespace($type . '.' . $slug, $path . '/config');
            }
        }


    }

    /**
     * Get the addon class suffix.
     *
     * @param $type
     * @param $slug
     * @return string
     */
    public function getNamespace($type, $slug)
    {
        return 'Addon\\' . Str::studly(basename($type)) . '\\' . Str::studly($slug);
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
        $type = Str::singular(basename(dirname($path)));
        $class = $this->getNamespace($type, basename($path)).'\\'.Str::studly(basename($path)).Str::studly($type);

        $addon = new $class;
        $addon->path = $path;
        $addon->slug = basename($path);

        // Load routes file
        if (is_file($addon->path . '/routes.php')) {
            require_once $addon->path . '/routes.php';
        }

        // Load events file
        if (is_file($addon->path . '/events.php')) {
            require_once $addon->path . '/events.php';
        }

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

        $paths = $paths + $this->getCoreAddonPaths();
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
        return glob(base_path() . '/app/addons/' . $this->folder . '/*');
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
