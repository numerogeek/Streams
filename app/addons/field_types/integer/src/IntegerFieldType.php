<?php namespace Addon\FieldType\Integer;

use Streams\Addon\FieldTypeAbstract;

class IntegerFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'integer';

    /**
     * Field type version
     *
     * @var string
     */
    public $version = '1.1.0';

    /**
     * Available field type settings.
     *
     * @var array
     */
    public $settings = array(
        'minimum',
        'maximum',
    );

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
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        return \Form::input('integer', $this->formSlug, $this->value);
    }
}
