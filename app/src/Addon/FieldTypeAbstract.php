<?php namespace Streams\Addon;

use Streams\Model\FieldModel;

abstract class FieldTypeAbstract extends AddonAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'string';

    /**
     * Column constraint
     *
     * @var string
     */
    public $columnConstraint = null;

    /**
     * Field type version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Field type author information.
     *
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc.',
        'url'  => 'http://aiwebsystems.com/',
    );

    /**
     * The type slug of the addon.
     *
     * @var string
     */
    public $addonType = 'field_type';

    /**
     * The field model.
     *
     * @var \Streams\Model\FieldModel
     */
    public $field;


    public function getColumnName($field)
    {
        return $field->slug;
    }

}
