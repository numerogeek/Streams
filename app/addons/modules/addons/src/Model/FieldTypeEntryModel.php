<?php namespace Addon\Module\Addons\Model;

use Streams\Model\Addons\AddonsFieldTypesEntryModel;

class FieldTypeEntryModel extends AddonsFieldTypesEntryModel
{
    protected $cacheMinutes = 30;

    /**
     * Collection class
     *
     * @var string
     */
    public $collectionClass = 'Addon\Module\Addons\Collection\FieldTypeEntryCollection';
}
