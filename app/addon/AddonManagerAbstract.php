<?php namespace App\Addon;

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
        require $path . '/' . Str::studly(basename($path)) . '.php';

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

        $paths = $paths + $this->getSharedAddonPaths();
        $paths = $paths + $this->getApplicationAddonPaths();

        return $paths;
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