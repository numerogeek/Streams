<?php namespace Streams\Addon;

abstract class AddonAbstract
{
    /**
     * The type slug of the addon.
     *
     * @var string
     */
    public $addonType = null;

    /**
     * The installer logic for the addon.
     *
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * The uninstall logic for the addon.
     *
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}
