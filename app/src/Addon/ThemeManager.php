<?php namespace Streams\Addon;

class ThemeManager extends AddonManagerAbstract
{
    protected $classSuffix = 'Theme';

    /**
     * The folder within addons locations to load themes from.
     *
     * @var string
     */
    protected $folder = 'themes';
}
