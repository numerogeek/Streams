<?php namespace Streams\Addon;

abstract class AddonAbstract
{
    /**
     * The addon type.
     *
     * @var string
     */
    public $type = null;

    /**
     * The addon slug
     *
     * @var string
     */
    public $slug;

    /**
     * Is this addon installed?
     *
     * @var null
     */
    protected $isInstalled = null;

    /**
     * Is this addon enabled?
     *
     * @var null
     */
    protected $isEnabled = null;

    /**
     * Get the traslated addon name
     *
     * @return string
     */
    public function getName()
    {
        return \Lang::trans($this->type . '.' . $this->slug . '::addon.name');
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
     * Is this addon installed?
     *
     * @return bool
     */
    public function isInstalled()
    {
        return (bool)$this->isInstalled;
    }

    /**
     * Is this addon enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->isEnabled;
    }

    /**
     * Set the isInstalled property.
     *
     * @return bool
     */
    public function setIsInstalled($isInstalled)
    {
        $this->isInstalled = $isInstalled;

        return $this;
    }

    /**
     * Set the isEnabled property.
     *
     * @return bool
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
