<?php namespace StreamsInstaller;

/**
 * Class InstallerAddonImporter
 * Install all addons.
 *
 * @package StreamsInstaller
 */
class InstallerAddonImporter
{
    public function install()
    {
        foreach (\Module::getAll() as $module) {
            \Module::install($module->slug);
        }

        foreach (\Theme::getAll() as $theme) {
            \Theme::install($theme->slug);
        }
    }
}