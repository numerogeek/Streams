<?php namespace Streams\Manager;

class ThemeManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load themes from.
     *
     * @var string
     */
    protected $folder = 'themes';

    /**
     * Get the active admin theme.
     *
     * @return null
     */
    public function getAdminTheme()
    {
        $themes = $this->getAll();

        foreach ($themes as $theme) {
            if ($theme->isAdmin() and $theme->isInstalled() and $theme->isEnabled()) {
                return $theme;
            }
        }

        return null;
    }
}
