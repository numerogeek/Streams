<?php namespace App\Addon\Block;

use App\Addon\AddonServiceProviderAbstract;

class BlockServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\Block\BlockManager';
}
