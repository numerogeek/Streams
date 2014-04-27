<?php namespace Addon\FieldType\Keywords;

use Streams\Addon\FieldTypeAbstract;

class KeywordsFieldType extends FieldTypeAbstract
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
        'return_type',
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
     * Output form input
     *
     * @param    array
     * @param    array
     * @return    string
     */
    public function formInput()
    {
        $options['name']        = $this->formSlug;
        $options['id']          = 'id_' . rand(100, 10000);
        $options['class']       = 'tags';
        $options['value']       = \Keywords::get_string($this->value);
        $options['placeholder'] = lang_label($this->getParameter('placeholder'));

        return form_input($options);
    }

    /**
     * Pre save
     *
     * @return string
     */
    public function preSave()
    {
        return null; //\Keywords::process($this->value);
    }

    /**
     * String output
     *
     * @return array|string
     */
    public function stringOutput()
    {
        return $this->getKeywordsValue();
    }

    /**
     * Plugin output
     *
     * @return array|string
     */
    public function pluginOutput()
    {
        return $this->getKeywordsValue('array');
    }

    /**
     * Plugin format override
     *
     * @param string $format
     * @return array|string
     */
    public function pluginFormatOverride($format)
    {
        return $this->getKeywordsValue($format);
    }

    /**
     * Get keywords value
     *
     * @param string $format
     * @return array|string
     */
    public function getKeywordsValue($format = 'array')
    {
        if (!$this->value) {
            return null;
        }

        // if we want an array, format it correctly
        if ($format === 'array') {
            $keyword_array = \Keywords::get_array($this->value);
            $keywords      = array();
            $total         = count($keyword_array);

            foreach ($keyword_array as $key => $value) {
                $keywords[] = array(
                    'count'    => $key,
                    'total'    => $total,
                    'is_first' => $key == 0,
                    'is_last'  => $key == ($total - 1),
                    'keyword'  => $value
                );
            }

            return $keywords;
        }

        // otherwise return it as a string
        return \Keywords::get_string($this->value);
    }

    /**
     * Return type parameter
     *
     * @param  string $value
     * @return array
     */
    public function paramReturnType($value = 'array')
    {
        return array(
            'instructions' => lang('streams:keywords.return_type.instructions'),
            'input'        =>
                '<label>' . form_radio('return_type', 'array', $value == 'array') . ' Array </label><br/>'
                // String gets set as default for backwards compat
                . '<label>' . form_radio('return_type', 'string', $value !== 'array') . ' String </label> '
        );
    }
}
