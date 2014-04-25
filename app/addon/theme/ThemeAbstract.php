<?php namespace App\Addon\Theme;

use App\Addon\AddonAbstract;

abstract class ThemeAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'theme';
}
