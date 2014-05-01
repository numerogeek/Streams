<?php namespace Addon\Module\Addons\Repository;

use Addon\Module\Addons\Contract\ModuleRepositoryInterface;
use Addon\Module\Addons\Model\ModuleEntryModel;
use Composer\Autoload\ClassLoader;

class StreamsModuleRepository extends StreamsAddonRepositoryAbstract implements ModuleRepositoryInterface
{
    /**
     * Create a new StreamsModuleRepository instance.
     */
    public function __construct()
    {
        $this->manager = \App::make('streams.modules');
        $this->addons  = new ModuleEntryModel();
    }
}