<?php namespace App\Addon;

abstract class AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = null;

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
