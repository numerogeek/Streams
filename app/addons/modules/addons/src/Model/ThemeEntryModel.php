<?php namespace Addon\Module\Addons\Model;

use Addon\Module\Addons\Traits\SyncTrait;
use Streams\Model\Addons\AddonsThemesEntryModel;

class ThemeEntryModel extends AddonsThemesEntryModel
{
    use SyncTrait;

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

    /**
     * Manager class
     *
     * @var string
     */
    public $managerClass = 'Streams\Manager\ThemeManager';
}
