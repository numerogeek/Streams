<?php namespace App\Addons\Modules;

use App\Addons\AddonServiceProviderAbstract;

class ModuleServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * Create a new ModuleServiceProvider instance
     */
    public function __construct()
    {
        $this->manager = new ModuleManager();
    }

    /**
     * Boot
     */
    public function boot()
    {
        parent::boot();

        foreach (glob(base_path() . '/addons/shared/modules/*') as $module) {
            if ($module = $this->manager->make($module)) {
                parent::register($module);
            }
        }
    }
}
