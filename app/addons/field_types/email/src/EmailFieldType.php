<?php namespace Addon\FieldType\Email;

use Streams\Addon\FieldTypeAbstract;

class EmailFieldType extends FieldTypeAbstract
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
     * Initial field type validation requirements.
     *
     * @var array
     */
    public $validation = array('email');

    /**
     * Field type author information.
     *
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc.',
        'url'  => 'http://aiwebsystems.com/'
    );

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        return \Form::input(
            'text',
            $this->form_slug,
            $this->value,
            array(
                'placeholder' => $this->getPlacehoder()
            )
        );
    }
}
