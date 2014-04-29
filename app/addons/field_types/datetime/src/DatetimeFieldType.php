<?php namespace Addon\FieldType\Text;

use Streams\Addon\FieldTypeAbstract;

class DatetimeFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'datetime';

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
