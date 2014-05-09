<?php namespace Addon\Module\Addons\Model;

use Streams\Model\Addons\AddonsModulesEntryModel;

class ModuleEntryModel extends AddonsModulesEntryModel
{
    /**
     * Minutes to cache queries for.
     *
     * @var int
     */
    protected $cacheMinutes = 60;

    /**
     * Collection class
     *
     * @var string
     */
    public $collectionClass = 'Addon\Module\Addons\Collection\ModuleEntryCollection';
}
