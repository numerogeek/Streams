<?php namespace App\Addon\Tag;

use App\Addon\AddonServiceProviderAbstract;

class TagServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\Tag\TagManager';
}
