<?php namespace App\Addons\Modules;

use App\Addons\AddonAbstract;

abstract class ModuleAbstract extends AddonAbstract
{
    /**
     * Autoload directories
     * @var array
     */
    protected $autoloadDirectories = array(
        'controllers' => 'Controller'
    );
}
