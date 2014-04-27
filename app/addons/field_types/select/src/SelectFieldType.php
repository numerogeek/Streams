<?php namespace Addon\FieldType\Select;

use Streams\Addon\FieldTypeAbstract;

class SelectFieldType extends FieldTypeAbstract
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
        'options',
        'is_multiselect',
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
        if ($options = $this->getOptions() and !$this->field->is_required) {
            $options = array(null => $this->getPlaceholder()) + $options;
        }

        return \Form::select(
            $this->formSlug,
            $options,
            $this->value
        );
    }

    /**
     * Return the string output value.
     *
     * @return null
     */
    public function stringOutput()
    {
        return $this->getOption($this->value);
    }

    /**
     * Return the plugin output value.
     *
     * @return null
     */
    public function pluginOutput()
    {
        if ($this->value) {
            return array(
                'value' => $this->getOption($this->value),
                'key'   => $this->value,
            );
        }

        return null;
    }

    /**
     * Get the option value from it's value.
     *
     * @param null $value
     * @return null
     */
    public function getOption($value)
    {
        $options = $this->getOptions();

        return isset($options[$value]) ? $options[$value] : null;
    }

    /**
     * Get options as an associative array.
     *
     * @return array
     */
    public function getOptions()
    {
        // @todo - Return options as associative array here. Don't forget support for optgroups.
    }
}
