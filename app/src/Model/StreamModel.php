<?php namespace Streams\Model;

use Streams\Entry\EntryModelGenerator;
use Streams\Exception\EmptyStreamNamespaceException;
use Streams\Exception\EmptyStreamSlugException;
use Streams\Exception\Exception;

class StreamModel extends EloquentModel
{
    /**
     * The collection class to use.
     *
     * @var string
     */
    protected $collectionClass = 'Streams\Collection\StreamCollection';

    /**
     * Cache streams as we fetch them.
     *
     * @var array
     */
    protected static $runtimeCache = array();

    /**
     * Disable updated_at and created_at on table.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_streams';

    /**
     * Cache minutes
     *
     * @var boolean/int
     */
    protected $cacheMinutes = false;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Create a new stream.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|object|static
     * @throws \Streams\Exception\EmptyStreamNamespaceException
     * @throws \Streams\Exception\EmptyStreamSlugException
     */
    public static function create(array $attributes = array())
    {
        // Do we have a namespace?
        if (!isset($attributes['namespace']) or !trim($attributes['namespace'])) {
            throw new EmptyStreamNamespaceException;
        }

        // Do we have a slug?
        if (!isset($attributes['slug']) or !trim($attributes['slug'])) {
            throw new EmptyStreamSlugException;
        }

        // Fallback to some defaults.
        $attributes['sort_by']      = isset($attributes['sort_by']) ? $attributes['sort_by'] : 'title';
        $attributes['view_options'] = isset($attributes['view_options']) ? $attributes['view_options'] : array(
            'id',
            'created_at'
        );
        $attributes['prefix']       = isset($attributes['prefix']) ? $attributes['prefix'] : null;

        // Check that the entry does not already exist and make it if not.
        if (!$stream = static::findBySlugAndNamespace($attributes['slug'], $attributes['namespace'])) {
            $stream = parent::create($attributes);
        }

        // Make sure the table does not exist too. Otherwise create it.
        if (!\Schema::hasTable($attributes['prefix'] . $attributes['slug'])) {
            \Schema::create(
                $attributes['prefix'] . $attributes['slug'],
                function ($table) {
                    $table->increments('id');
                    $table->integer('sort_order')->nullable();
                    $table->datetime('created_at');
                    $table->datetime('updated_at')->nullable();
                    $table->integer('created_by')->nullable();
                }
            );
        }

        return $stream;
    }

    /**
     * Find a stream by it's slug and namespace.
     *
     * @param $slug
     * @param $namespace
     * @return mixed
     */
    public static function findBySlugAndNamespace($slug, $namespace)
    {
        $stream = static::with('assignments.field')
            ->where('namespace', $namespace)
            ->where('slug', $slug)
            ->take(1)
            ->first();

        return $stream;
    }

    /**
     * Find many streams by namespace.
     *
     * @param      $namespace
     * @param int  $take
     * @param null $skip
     * @return mixed
     */
    public static function findManyByNamespace($namespace, $take = 0, $skip = null)
    {
        $query = static::where('namespace', '=', $namespace);

        if ($take > 0) {
            $query = $query->take($take)->skip($skip);
        }

        return $query->get();
    }

    /**
     * Delete
     *
     * @return boolean
     */
    public function delete()
    {
        try {
            \Schema::dropIfExists($this->getTableName());
        } catch (Exception $e) {
            // @todo - log error
        }

        if ($success = parent::delete()) {
            FieldAssignmentModel::cleanup();
            FieldModel::cleanup();
        }

        return $success;
    }

    /**
     * Assign a field to this stream.
     *
     * @param  string $field
     * @param  mixed  $data
     * @return boolean
     */
    public function assignField(FieldModel $field = null, $data = array(), $createColumn = true)
    {
        if (is_numeric($field)) {
            $field = FieldModel::findOrFail($field);
        }

        if (!$fieldAssignment = FieldAssignmentModel::findByFieldIdAndStreamId(
            $field->getKey(),
            $this->getKey(),
            true
        )
        ) {
            $fieldAssignment = new FieldAssignmentModel;
        }

        // Is this the title column?
        if (isset($data['title_column']) and $data['title_column'] === true) {
            $update_data['title_column'] = $field->slug;

            $this->update($update_data);
        }

        // Create an assignment
        $fieldAssignment->stream_id = $this->getKey();
        $fieldAssignment->field_id  = $field->getKey();

        $fieldAssignment->is_required = isset($data['is_required']) ? $data['is_required'] : false;
        $fieldAssignment->is_unique   = isset($data['is_unique']) ? $data['is_unique'] : false;

        if (isset($data['instructions'])) {
            $fieldAssignment->instructions = $data['instructions'];
        } else {
            $fieldAssignment->instructions = "{$this->namespace}::fields.{$field->slug}.instructions";
        }

        // First one! Make it 1
        $fieldAssignment->sort_order = FieldAssignmentModel::getIncrementalSortNumber($this->getKey());

        // Return the field assignment or false
        return $fieldAssignment->save() ? $fieldAssignment : false;
    }


    /**
     * Update Stream
     *
     * @param    int
     * @param    array - attributes
     * @return    bool
     */
    public function update(array $attributes = array())
    {
        $attributes['prefix'] = isset($attributes['prefix']) ? $attributes['prefix'] : null;
        $attributes['slug']   = isset($attributes['slug']) ? $attributes['slug'] : $this->slug;

        $from = $this->getTableName();
        $to   = $attributes['prefix'] . $attributes['slug'];

        try {
            if (!empty($to) and \Schema::hasTable($from) and $from != $to) {
                \Schema::rename($from, $to);
            }
        } catch (Exception $e) {
            // @todo - throw exception
        }

        return parent::update($attributes);
    }

    /**
     * Save the stream.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = array())
    {
        //$this->compileEntryModel();
        return parent::save($options);
    }

    /**
     * Compile entry model.
     *
     * @return bool
     */
    public function compileEntryModel()
    {
        $generator = new EntryModelGenerator;
        return $generator->compile($this);
    }

    /**
     * Get view options
     *
     * @param  string $view_options
     * @return array
     */
    public function getViewOptionsAttribute($view_options)
    {
        if (!is_string($view_options)) {
            return $view_options;
        }

        return json_decode($view_options);
    }

    /**
     * Set view options
     *
     * @param array $view_options
     */
    public function setViewOptionsAttribute($view_options)
    {
        $this->attributes['view_options'] = json_encode($view_options);
    }

    /**
     * Get permissions attribute
     *
     * @param  string $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return json_decode($permissions);
    }

    /**
     * Set permissions
     *
     * @param array $permissions
     */
    public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = json_encode($permissions);
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->prefix . $this->slug;
    }

    /**
     * Span new class
     *
     * @return object
     */
    public function assignments()
    {
        return $this->hasMany('Streams\Model\FieldAssignmentModel', 'stream_id')->orderBy('sort_order');
    }
}
