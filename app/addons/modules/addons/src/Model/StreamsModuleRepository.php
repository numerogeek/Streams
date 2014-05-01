<?php namespace ADdon\Module\Addons\Model;

use Addon\Module\Addons\Repository\ModuleRepository;
use Streams\Collection\ModuleCollection;

class StreamsModuleRepository implements ModuleRepository
{
    public function __construct()
    {

    }

    public function sync(ModuleCollection $modules)
    {
        //$dataModules = $this->all();
    }
}