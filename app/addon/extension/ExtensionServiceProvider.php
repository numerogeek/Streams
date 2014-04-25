<?php namespace App\Addon\Extension;

use App\Addon\AddonServiceProviderAbstract;

class ExtensionServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\Extension\ExtensionManager';
}
