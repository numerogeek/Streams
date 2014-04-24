<?php namespace App\Addons;

abstract class AddonAbstract
{
    /**
     * Autoload directories
     * @var array
     */
    protected $autoloadDirectories = array();

    /**
     * Get autoload directories
     * @return array
     */
    public function getAutoloadDirectories()
    {
        return $this->autoloadDirectories;
    }
}