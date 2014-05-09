<?php namespace Addon\Module\Addons\Model;

use Streams\Model\Addons\AddonsThemesEntryModel;

class ThemeEntryModel extends AddonsThemesEntryModel
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
    public $collectionClass = 'Addon\Module\Addons\Collection\ThemeEntryCollection';
}
