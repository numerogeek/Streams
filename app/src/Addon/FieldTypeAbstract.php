<?php namespace Streams\Addon;

use Streams\Model\FieldModel;

abstract class FieldTypeAbstract extends AddonAbstract
{
    /**
     * The type slug of the addon.
     *
     * @var string
     */
    public $addonType = 'field_type';

    /**
     * Column constraint (for the string column type)
     *
     * @var string
     */
    public $columnConstraint = null;

    /**
     * Column type
     *
     * @var string
     */
    public $columnType = 'text';

    /**
     * @var \Streams\Model\FieldModel
     */
    public $field;

    public function setField(FieldModel $field)
    {
        $this->field = $field;

        return $this;
    }

    public function getColumnName()
    {
        return $this->field->slug;
    }

}
