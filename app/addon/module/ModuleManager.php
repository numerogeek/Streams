<?php namespace App\Addon\Module;

use App\Addon\AddonManagerAbstract;

class ModuleManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load modules from.
     *
     * @var string
     */
    protected $folder = 'modules';
}
