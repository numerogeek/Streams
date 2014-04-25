<?php namespace App\Addon\FieldType;

use App\Addon\AddonAbstract;

abstract class FieldTypeAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     * @var string
     */
    public $type = 'field_type';
}
