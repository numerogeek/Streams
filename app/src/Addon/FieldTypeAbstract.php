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
     * Get column name
     * @param FieldModel $field
     * @return mixed
     */
    public function getColumnName(FieldModel $field)
    {
        return $field->slug;
    }
}
