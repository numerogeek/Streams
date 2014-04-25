<?php namespace App\Addon\FieldType;

use App\Addon\AddonManagerAbstract;

class FieldTypeManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load field_types from.
     *
     * @var string
     */
    protected $folder = 'field_types';
}
