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
     * Get the traslated addon name
     *
     * @return string
     */
    public function getName()
    {
        return \Lang::trans($this->addonType . '.' . $this->slug . '::addon.name');
    }

    /**
     * Is this a core addon?
     *
     * @var bool
     */
    public function isCore()
    {
        return (strpos($this->path, base_path('app/')) !== false);
    }

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
