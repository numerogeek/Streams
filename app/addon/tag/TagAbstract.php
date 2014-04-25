<?php namespace App\Addon\Tag;

use App\Addon\AddonAbstract;

abstract class TagAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'tag';
}
