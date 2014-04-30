<?php namespace Streams\Addon;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Str;
use Streams\Schema\FieldSchema;
use Streams\Schema\StreamSchema;

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

            // Register controllers directory
            $this->loader->addPsr4(
                $this->getNamespace($type, $slug) . '\\Schema\\',
                $path . '/schemas'
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
            \Config::addNamespace($loaderNamespace, $info['path'] . '/config');

            // Add views namespace
            \View::addNamespace($loaderNamespace, $info['path'] . '/views');

            // Load events file
            if (is_file($info['path'] . '/events.php')) {
                require_once $info['path'] . '/events.php';
            }

            // Load routes file
            if (is_file($info['path'] . '/routes.php')) {
                require_once $info['path'] . '/routes.php';
            }

            // Register a singleton addon
            \App::singleton(
                'streams.' . $info['type'] . '.' . $info['slug'],
                function () use ($info, $loaderNamespace) {

                    $addonClass = $this->getClass($info['slug']);

                    $addon = new $addonClass;

                    // Add lang namespace
                    \Lang::addNamespace($loaderNamespace, $info['path'] . '/lang');

                    $addon->path   = $info['path'];
                    $addon->slug   = $info['slug'];
                    $addon->isCore = (substr($info['path'], 0, 4) === 'src/');

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

    /**
     * Return the schema classes in a given module.
     *
     * @param $slug
     * @return array
     */
    public function getSchemaClasses($slug)
    {
        $addon = $this->get($slug);

        $classes = array();

        if (is_dir("{$addon->path}/src/Schema")) {
            foreach (glob("{$addon->path}/src/Schema/*Schema.php") as $filename) {
                $classes[] = 'Addon\\Module\\' . Str::studly($slug) . '\\Schema\\' .
                    str_replace(
                        '.php',
                        '',
                        basename($filename)
                    );
            };
        }

        return $classes;
    }

    /**
     * Get schemas.
     *
     * @param $slug
     * @return array
     */
    public function getSchemas($slug)
    {
        $addon = $this->get($slug);

        $schemas = array();

        foreach ($this->getSchemaClasses($slug) as $schemaClass) {
            $schemas[] = new $schemaClass($addon);
        }

        return $schemas;
    }

    /**
     * Install a module.
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        $module = $this->get($slug);

        if ($this->installSchemas($slug)) {
            if ($module->install()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Uninstall a module.
     *
     * @param $slug
     * @return bool
     */
    public function uninstall($slug)
    {
        $module = $this->get($slug);

        if ($this->uninstallSchemas($slug)) {
            if ($module->uninstall()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Install schemas.
     *
     * @param $slug
     */
    public function installSchemas($slug)
    {
        $schemas = $this->getSchemas($slug);

        foreach ($schemas as $fieldSchema) {
            if ($fieldSchema instanceof FieldSchema) {
                $fieldSchema->getInstaller()->install();
            }
        }

        foreach ($schemas as $streamSchema) {
            if ($streamSchema instanceof StreamSchema) {
                $streamSchema->getInstaller()->install();
            }
        }

        return true;
    }

    /**
     * Uninstall schemas.
     *
     * @param $slug
     */
    public function uninstallSchemas($slug)
    {
        $schemas = $this->getSchemas($slug);

        foreach ($schemas as $fieldSchema) {
            if ($fieldSchema instanceof FieldSchema) {
                $fieldSchema->getInstaller()->uninstall();
            }
        }

        foreach ($schemas as $streamSchema) {
            if ($streamSchema instanceof StreamSchema) {
                $streamSchema->getInstaller()->uninstall();
            }
        }
    }
}
