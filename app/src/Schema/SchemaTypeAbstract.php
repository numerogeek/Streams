<?php namespace Streams\Schema;

use Streams\Addon\AddonAbstract;

abstract class SchemaTypeAbstract
{
    public $addon;

    public function __construct(AddonAbstract $addon = null)
    {
        $this->addon = $addon;
    }

    /**
     * Installer class
     *
     * @var
     */
    protected $installerClass;

    /**
     * Get Instatiated installer
     *
     * @return \Streams\Schema\SchemaAbstract
     */
    public function getInstaller()
    {
        return new $this->installerClass($this, $this->addon);
    }

}