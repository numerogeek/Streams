<?php namespace Addon\Module\Addons\Repository;

use Addon\Module\Addons\Contract\ThemeRepositoryInterface;
use Addon\Module\Addons\Model\ModuleEntryModel;
use Composer\Autoload\ClassLoader;

class StreamsThemeRepository extends StreamsAddonRepositoryAbstract implements ThemeRepositoryInterface
{
    /**
     * Create a new StreamsThemeRepository instance.
     */
    public function __construct()
    {
        $this->manager = \App::make('streams.themes');
        $this->addons  = new ThemeEntryModel();
    }
}