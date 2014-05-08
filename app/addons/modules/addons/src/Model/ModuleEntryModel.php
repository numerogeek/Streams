<?php namespace Addon\Module\Addons\Model;

use Streams\Model\Addons\AddonsModulesEntryModel;

class ModuleEntryModel extends AddonsModulesEntryModel
{
    protected $cacheMinutes = 30;

    /**
     * Collection class
     *
     * @var string
     */
    public $collectionClass = 'Addon\Module\Addons\Collection\ModuleEntryCollection';
}
