<?php namespace App\Addon\Block;

use App\Addon\AddonManagerAbstract;

class BlockManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load blocks from.
     *
     * @var string
     */
    protected $folder = 'blocks';
}
