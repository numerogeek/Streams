<?php namespace Addon\Module\Addons\Repository;

use Streams\Collection\ModuleCollection;

interface ModuleRepository
{
    public function sync(ModuleCollection $modules);
}