<?php namespace App\Addon\Extension;

use App\Addon\AddonManagerAbstract;

class ExtensionManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load extensions from.
     *
     * @var string
     */
    protected $folder = 'extensions';
}
