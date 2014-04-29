<?php namespace Streams\Addon;

abstract class AddonAbstract
{
    /**
     * The addon type.
     *
     * @var string
     */
    public $addonType = null;

    /**
     * The addon slug
     *
     * @var string
     */
    public $slug;

    /**
     * Array of classes that describe installable schemas
     *
     * @var array
     */
    public $schemas = array();

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
