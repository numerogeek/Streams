<?php namespace Addon\FieldType\State;

use Streams\Addon\FieldTypeAbstract;

class StateFieldType extends FieldTypeAbstract
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
        'countries',
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
        if ($states = $this->getStates() and !$this->field->is_required) {
            $states = array(null => $this->getPlaceholder()) + $states;
        }

        return \Form::select(
            $this->formSlug,
            $states,
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
        return $this->getState($this->value);
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
                'name' => $this->getState($this->value),
                'code' => $this->value,
            );
        }

        return null;
    }

    /**
     * Get the state name from it's code.
     *
     * @param null $code
     * @return null
     */
    public function getState($code)
    {
        $states = $this->getStates();

        return isset($states[$code]) ? $states[$code] : null;
    }

    /**
     * Get state options as an associative array.
     *
     * @return array
     */
    public function getStates()
    {
        return array(
            'United States' => array(
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Deleware',
                'DC' => 'District of Columbia',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            ),
        );
    }
}
