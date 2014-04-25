<?php namespace App\Addon\Extension;

use App\Addon\AddonAbstract;

abstract class ExtensionAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'extension';
}
