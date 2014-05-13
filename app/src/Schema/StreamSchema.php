<?php namespace Streams\Schema;

use Streams\Traits\InstallableEventsTrait;

class StreamSchema extends SchemaTypeAbstract
{
    use InstallableEventsTrait;

    /**
     * Stream namespace
     *
     * @var string
     */
    public $namespace;

    /**
     * Stream slug
     *
     * @var string
     */
    public $slug;

    /**
     * Stream prefix used for creating the table
     *
     * @var string
     */
    public $prefix;

    /**
     * Stream name / language string (recommended)
     *
     * @var string
     */
    public $name;

    /**
     * Stream name / language string (recommended)
     *
     * @var string
     */
    public $description;

    /**
     * The title column
     *
     * @var string
     */
    public $titleColumn;

    /**
     * Sort by title ($titleColumn) or custom
     *
     * @var boolean
     */
    public $sortBy = 'title';

    /**
     * Stream default view options
     * An array of field slugs
     *
     * @var array
     */
    public $viewOptions = array('id', 'created_at');

    /**
     * Menu path
     *
     * @var string
     */
    public $menuPath;

    /**
     * Is the stream hidden?
     *
     * @var boolean
     */
    public $isHidden = false;

    /**
     * Array of field assignments keyed by field slug
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
    public function assignments()
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