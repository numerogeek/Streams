<?php namespace Streams\Schema;

use Streams\Traits\InstallableEventsTrait;

class FieldSchema extends SchemaTypeAbstract
{
    use InstallableEventsTrait;

    /**
     * Fields namespace
     *
     * @var string
     */
    public $namespace;

    /**
     * Array of fields keyed by field slug
     *
     * The fields must be in the same namespace as the stream
     * Example
     * return array(
     *      'foo' => array(
     *          'is_required' => true
     *          'settings' => array(
     *              'max_length' => 255
     *          )
     *      ),
     * )
     *
     * @var array
     */
    public function fields()
    {
        return array();
    }

    /**
     * Installer class
     *
     * @var string
     */
    protected $installerClass = 'Streams\Schema\StreamSchemaInstaller';

}