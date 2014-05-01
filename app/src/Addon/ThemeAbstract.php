<?php namespace Streams\Addon;

abstract class ThemeAbstract extends AddonAbstract
{
    /**
     * By default this is not an admin theme.
     *
     * @var bool
     */
    protected $isAdmin = false;

    /**
     * Return whether this theme is admin or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (bool)$this->isAdmin;
    }
}
