<?php namespace App\Addons\Modules;

use App\Addons\AddonServiceProviderAbstract;

class ModuleServiceProvider extends AddonServiceProviderAbstract
{
    public function __construct()
    {
        $this->manager = new ModuleManager();
    }

    public function boot()
    {
        foreach (glob(base_path() . '/addons/shared/modules/*') as $module) {
            if ($module = $this->manager->make($module)) {
                parent::boot($module);
                parent::register($module);
            }
        }
    }
}