<?php namespace App\Addon\Tag;

use App\Addon\AddonManagerAbstract;

class TagManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load tags from.
     *
     * @var string
     */
    protected $folder = 'tags';
}
