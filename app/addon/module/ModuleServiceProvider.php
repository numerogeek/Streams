<?php namespace App\Addon\Module;

use App\Addon\AddonServiceProviderAbstract;

class ModuleServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\Module\ModuleManager';
}
