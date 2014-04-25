<?php namespace App\Addon\Block;

use App\Addon\AddonAbstract;

abstract class BlockAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'block';
}
