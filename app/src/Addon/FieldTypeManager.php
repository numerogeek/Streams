<?php namespace Streams\Addon;

class FieldTypeManager extends AddonManagerAbstract
{
    protected $classSuffix = 'FieldType';

    /**
     * The folder within addons locations to load field_types from.
     *
     * @var string
     */
    protected $folder = 'field_types';
}
