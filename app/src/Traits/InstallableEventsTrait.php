<?php namespace Streams\Traits;

trait InstallableEventsTrait
{
    /**
     * On before install event
     *
     * @var boolean
     */
    public function onBeforeInstall()
    {
        return true;
    }

    /**
     * On after install event
     *
     * @var boolean
     */
    public function onAfterInstall()
    {
        return true;
    }

    /**
     * On before uninstall event
     *
     * @var boolean
     */
    public function onBeforeUninstall()
    {
        return true;
    }

    /**
     * On after uninstall event
     *
     * @var boolean
     */
    public function onAfterUninstall()
    {
        return true;
    }
}