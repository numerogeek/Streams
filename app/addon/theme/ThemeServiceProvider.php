<?php namespace App\Addon\Theme;

use App\Addon\AddonServiceProviderAbstract;

class ThemeServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\Theme\ThemeManager';
}
