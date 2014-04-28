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

    /**
     * Collection class
     *
     * @var null
     */
    protected $collectionClass = null;

    /**
     * Create a new AddonManagerAbstract instance.
     *
     * @param ClassLoader $loader
     */
    public function __construct(Classloader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Register an addon's path and structure.
     */
    public function register()
    {
        foreach ($this->getAllAddonPaths() as $path) {

            $slug = basename($path);
            $type = strtolower(Str::singular(basename(dirname($path))));

            $this->collectionClass = 'Streams\Collection\\' . Str::studly($type . 'Collection');

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

            $this->registeredAddons[$slug] = array(
                'path'      => $path,
                'slug'      => $slug,
                'type'      => $type,
                'namespace' => $this->getNamespace($type, $slug),
            );
        }

        foreach ($this->registeredAddons as $info) {

            $loaderNamespace = $info['type'] . '.' . $info['slug'];

            // Add config namespace
            \Config::addNamespace($loaderNamespace,  $info['path'] . '/config');

            // Add views namespace
            \View::addNamespace($loaderNamespace, $info['path'] . '/views');

            // Load events file
            if (is_file($path . '/events.php')) {
                require_once $path . '/events.php';
            }

            // Load routes file
            if (is_file($path . '/routes.php')) {
                require_once $path . '/routes.php';
            }

            // Register a singleton addon
            \App::singleton(
                'streams.' . $info['type'] . '.' . $info['slug'],
                function () use ($info, $loaderNamespace) {

                    $addonClass = $this->getClass($info['slug']);

                    $addon = new $addonClass;

                    // Add lang namespace
                    \Lang::addNamespace($loaderNamespace, $info['path'] . '/lang');

                    $addon->path = $info['path'];
                    $addon->slug = $info['slug'];

                    return $addon;
                }
            );
        }
    }

    /**
     * @param $slug
     * @return AddonAbstract
     */
    public function get($slug)
    {
        return \App::make('streams.' . Str::singular($this->folder) . '.' . $slug);
    }

    /**
     * Get all instantiated addons.
     *
     * @return array
     */
    public function getAll()
    {
        $addons = array();

        foreach ($this->registeredAddons as $info) {
            $addons[$info['slug']] = $this->get($info['slug']);
        }

        return new $this->collectionClass($addons);
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
     * Return the addon class.
     *
     * @param $slug
     * @return string
     */
    public function getClass($slug)
    {
        $info = $this->registeredAddons[$slug];
        return $info['namespace'] . '\\' . Str::studly($info['slug']) . Str::studly($info['type']);
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
