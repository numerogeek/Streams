<?php namespace ADdon\Module\Addons\Model;

use Addon\Module\Addons\Repository\ModuleRepository;
use Streams\Collection\ModuleCollection;
use Streams\Model\AddonsModulesEntryModel;

class ModuleEntryModel extends AddonsModulesEntryModel implements ModuleRepository
{
    public function sync(ModuleCollection $modules)
    {
        //echo $modelModules = $this->all();
    }
}