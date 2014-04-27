<?php namespace Addon\FieldType;

use Streams\Addon\FieldTypeAbstract;

class Encrypt extends FieldTypeAbstract
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
     * Available field type settings.
     *
     * @var array
     */
    public $settings = array(
        'hide_typing',
    );

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
     * Process value before saving.
     *
     * @return mixed
     */
    public function preSave()
    {
        return \Crypt::encrypt($this->value);
    }

    /**
     * Return the string output value.
     *
     * @return string
     */
    public function stringOutput()
    {
        return \Crypt::decrypt($this->value);
    }

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        $value = \Crypt::decrypt($this->value);

        $type = $this->getParameter('hide_typing', true) ? 'password' : 'text';

        return \Form::input($type, $this->form_slug, $value);
    }
}
