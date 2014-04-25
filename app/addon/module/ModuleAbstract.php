<?php namespace App\Addon\Module;

use App\Addon\AddonAbstract;

abstract class ModuleAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'module';
}
