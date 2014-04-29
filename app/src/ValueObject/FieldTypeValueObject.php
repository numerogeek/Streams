<?php namespace Streams\ValueObject;

use Streams\Model\EntryModel;
use Streams\Model\FieldModel;

class FieldTypeValueObject
{
    public $fieldSlug;

    public $entry;

    public function __construct($data = array())
    {
        if ($entry = array_get($data, 'entry') and $entry instanceof EntryModel) {
            $this->entry = $entry;
        }

        if ($field = array_get($data, 'field') and $field instanceof FieldModel) {
            $this->fieldSlug = $field->slug;
        }

        if ($field = array_get($data, 'field') and $field instanceof FieldModel) {
            $this->fieldSlug = $field->slug;
        }
    }

    public function __get($name)
    {
        return null;
    }
}