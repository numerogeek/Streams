<?php namespace Addon\FieldType\Boolean;

use Streams\Addon\FieldTypeAbstract;

class BooleanFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'boolean';

    /**
     * Column constraint
     *
     * @var string
     */
    public $columnConstraint = 1;

    /**
     * Field type version
     *
     * @var string
     */
    public $version = '1.1.0';

    /**
     * Field type author information.
     *
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc.',
        'url'  => 'http://aiwebsystems.com/',
    );
}
