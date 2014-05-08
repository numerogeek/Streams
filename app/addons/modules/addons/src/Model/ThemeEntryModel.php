<?php namespace Addon\Module\Addons\Model;

use Streams\Model\Addons\AddonsThemesEntryModel;

class ThemeEntryModel extends AddonsThemesEntryModel
{
    protected $cacheMinutes = 30;

    /**
     * Collection class
     *
     * @var string
     */
    public $collectionClass = 'Addon\Module\Addons\Collection\ThemeEntryCollection';
}
