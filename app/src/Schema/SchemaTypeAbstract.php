<?php namespace Streams\Schema;

abstract class SchemaTypeAbstract
{
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
        return new $this->installerClass($this);
    }

}