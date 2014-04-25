<?php namespace App\Addon\Theme;

use App\Addon\AddonManagerAbstract;

class ThemeManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load themes from.
     *
     * @var string
     */
    protected $folder = 'themes';
}
