<?php namespace Streams\Contract;

interface InstallerInterface
{
    /**
     * Install
     *
     * @return mixed
     */
    public function install();

    /**
     * Uninstall
     *
     * @return mixed
     */
    public function uninstall();

}