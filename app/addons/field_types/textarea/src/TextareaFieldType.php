<?php namespace Addon\FieldType\Textarea;

use Streams\Addon\FieldTypeAbstract;

class TextareaFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'string';

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

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        return \Form::textarea($this->formSlug, $this->value);
    }
}
