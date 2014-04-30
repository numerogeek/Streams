<?php namespace Streams\Model;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Streams\Entry\EntryModelGenerator;
use Streams\Collection\FieldAssignmentCollection;
use Streams\Collection\StreamCollection;
use Streams\Exception\EmptyFieldNameException;
use Streams\Exception\EmptyStreamNamespaceException;
use Streams\Exception\EmptyStreamSlugException;
use Streams\Exception\Exception;
use Streams\Exception\InvalidStreamModelException;
use Streams\Exception\StreamModelNotFoundException;
use Streams\Schema\StreamSchemaColumnCreator;

class StreamModel extends EloquentModel
{
    /**
     * Streams cache
     *
     * @var array
     */
    protected static $streamsCache = array();

    /**
     * Disable updated_at and created_at on table
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
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Create
     *
     * @param  array $attributes
     * @return boolean
     */
    public static function create(array $attributes = array())
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------

        // Do we have a namespace?
        if (!isset($attributes['namespace']) or !trim($attributes['namespace'])) {
            throw new EmptyStreamNamespaceException;
        }

        // Do we have a slug?
        if (!isset($attributes['slug']) or !trim($attributes['slug'])) {
            throw new EmptyStreamSlugException;
        }

        // -------------------------------------
        // Create Stream
        // -------------------------------------

        $attributes['sort_by']      = isset($attributes['sort_by']) ? $attributes['sort_by'] : 'title';
        $attributes['view_options'] = isset($attributes['view_options']) ? $attributes['view_options'] : array(
            'id',
            'created_at'
        );
        $attributes['prefix']       = isset($attributes['prefix']) ? $attributes['prefix'] : null;

        // Check if it doesn't exist
        if (!$stream = static::findBySlugAndNamespace($attributes['slug'], $attributes['namespace'])) {
            $stream = parent::create($attributes);
        }

        if (!$attributes['prefix'] and $attributes['prefix'] !== false) {
            $attributes['prefix'] = $attributes['namespace'] . '_';
        }

        $table = $attributes['prefix'] . $attributes['slug'];

        // See if table exists. You never know if it sneaked past validation
        if (!\Schema::hasTable($table)) {
            // Create the table for our new stream
            \Schema::create(
                $table,
                function ($table) {
                    $table->increments('id');
                    $table->integer('sort_order')->nullable();
                    $table->datetime('created_at');
                    $table->datetime('updated_at')->nullable();
                    $table->integer('created_by')->nullable();
                }
            );
        }

        // Create the stream in the data_streams table
        return $stream;
    }

    /**
     * This returns a consistent Eloquent
     * model from either the cache or a new query
     *
     * @param  string $slug
     * @param  string $namespace
     * @return object
     */
    public static function findBySlugAndNamespace($slug, $namespace)
    {
        $stream = static::with('assignments.field')
            ->where('namespace', $namespace)
            ->where('slug', $slug)
            ->take(1)
            ->first();

        if (!$stream) {
            //throw new InvalidStreamModelException('Invalid stream. Attempted [' . $namespace . ',' . $slug . ']');
        }

        return $stream;
    }

    /**
     * Get Stream Metadata
     * Returns an array of the following data:
     * name            The stream name
     * slug            The streams slug
     * namespace        The stream namespace
     * db_table        The name of the stream database table
     * raw_size        Raw size of the stream database table
     * size            Formatted size of the stream database table
     * entries_count    Number of the entries in the stream
     * fields_count    Number of fields assigned to the stream
     * last_updated        Unix timestamp of when the stream was last updated
     *
     * @access    public
     * @param    mixed  $stream    object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @return    object
     */
    public static function getStreamMetadata($slug = null, $namespace = null)
    {
        $stream = static::getStream($slug, $namespace);

        $data = array();

        $data['name']      = $stream->name;
        $data['slug']      = $stream->slug;
        $data['namespace'] = $stream->namespace;

        // Get DB table name
        $data['db_table'] = $stream->prefix . $stream->slug;

        // @todo - convert to Query Builder

        // Get the table data
        $info = ci()->db->query("SHOW TABLE STATUS LIKE '" . ci()->db->dbprefix($data['db_table']) . "'")->row();

        // Get the size of the table
        $data['raw_size'] = $info->Data_length;

        ci()->load->helper('number');
        $data['size'] = byte_format($info->Data_length);

        // Last updated time
        $data['last_updated'] = (!$info->Update_time) ? $info->Create_time : $info->Update_time;

        ci()->load->helper('date');
        $data['last_updated'] = mysql_to_unix($data['last_updated']);

        // Get the number of rows (the table status data on this can't be trusted)
        $data['entries_count'] = ci()->db->count_all($data['db_table']);

        // Get the number of fields
        $data['fields_count'] = ci()->db->select('id')->where('stream_id', $stream->id)->get(ASSIGN_TABLE)->num_rows();

        return $data;
    }

    /**
     * This returns a consistent Eloquent
     * Collection from either the cache or a new query
     *
     * @param  string  $namespace
     * @param  string  $limit
     * @param  integer $offset
     * @return object
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
     * Find a model by slug and namespace or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Streams\Model\StreamModel|Collection|static
     */
    public static function findBySlugAndNamespaceOrFail($slug, $namespace)
    {
        if (!is_null($model = static::findBySlugAndNamespace($slug, $namespace))) {
            return $model;
        }

        throw new StreamModelNotFoundException;
    }

    /**
     * Find by slug
     *
     * @param  string $slug
     * @return object
     */
    public static function findBySlug($slug = '')
    {
        return static::where('slug', $slug)->take(1)->first();
    }

    /**
     * Get ID from slug and namespace
     *
     * @param  string $slug
     * @param  string $namespace
     * @return mixed
     */
    public static function getIdFromSlugAndNamespace($slug, $namespace)
    {
        if ($stream = static::findBySlugAndNamespace($slug, $namespace)) {
            return $stream->id;
        }

        return false;
    }

    /**
     * Update title column by stream IDs
     *
     * @param  array   $stream_ids
     * @param  integer $from
     * @param  integer $to
     * @return object
     */
    public static function updateTitleColumnByStreamIds($stream_ids = null, $from = null, $to = null)
    {
        if (empty($stream_ids) or $from == $to) {
            return false;
        }

        if (!is_array($stream_ids)) {
            $stream_ids = array($stream_ids);
        }

        return static::whereIn('id', $stream_ids)
            ->where('title_column', $from)
            ->update(
                array(
                    'title_column' => $to
                )
            );
    }

    /**
     * Get Stream options
     *
     * @return array The array of Stream options indexed by id
     */
    public static function getStreamOptions()
    {
        return static::all(array('id', 'name', 'namespace'))->getStreamOptions();
    }

    /**
     * Get Stream associative options
     *
     * @return array The array of Stream options indexed by "slug.namespace"
     */
    public static function getStreamAssociativeOptions()
    {
        return static::all(array('namespace', 'slug', 'name'))->getStreamAssociativeOptions();
    }

    /**
     * Check if table exists
     *
     * @param  string $stream
     * @param  string $prefix
     * @return boolean
     */
    public static function tableExists($stream, $prefix = null)
    {
        if ($stream instanceof static) {
            $table = $stream->prefix . $stream->slug;
        } else {
            $table = $prefix . $stream;
        }

        return \Schema::hasTable($table);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Streams\Model\StreamModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new StreamModelNotFoundException;
    }

    public static function find($id, $columns = array('*'))
    {
        $stream = static::with('assignments.field')->where('id', $id)
            ->take(1)
            ->first();
    }

    /**
     * Get stream model object from stream data array
     *
     * @param  array $streamData
     * @return Streams\Model\StreamModel
     */
    public static function object($streamData)
    {
        $fieldAssignments = array();

        if (is_array($streamData) and !empty($streamData['assignments'])) {

            foreach ($streamData['assignments'] as $fieldAssignment) {

                if (!empty($fieldAssignment['field'])) {
                    $fieldModel = new FieldModel($fieldAssignment['field']);
                    unset($fieldAssignment['field']);
                }

                $fieldAssignmentModel = new FieldAssignmentModel($fieldAssignment);

                $fieldAssignmentModel->setRawAttributes($fieldAssignment);

                $fieldAssignmentModel->setRelation('field', $fieldModel);

                $fieldAssignments[] = $fieldAssignmentModel;
            }

            unset($streamData['assignments']);
        }

        $streamModel = new static;

        $streamModel->setRawAttributes($streamData);

        $fieldAssignmentsCollection = new FieldAssignmentCollection($fieldAssignments);

        $streamModel->setRelation('assignments', $fieldAssignmentsCollection);

        $streamModel->assignments = $fieldAssignmentsCollection;

        return static::$streamsCache[$streamModel->namespace . '.' . $streamModel->slug] = $streamModel;
    }

    /**
     * Get stream cache name
     *
     * @param  string $slug
     * @param  string $namespace
     * @return object
     */
    protected static function getStreamCacheName($slug = '', $namespace = '')
    {
        return 'stream[' . $slug . ',' . $namespace . ']';
    }

    /**
     * Validation Array
     * Get a validation array for a stream. Takes
     * the format of an array of arrays like this:
     * array(
     * 'field' => 'email',
     * 'label' => 'Email',
     * 'rules' => 'required|valid_email'
     */
    public function validationArray(
        $stream,
        $namespace = null,
        $method = 'new',
        $skips = array(),
        $row_id = null
    ) {
        if (!$stream instanceof static) {
            if (!$stream = static::findBySlugAndNamespace($stream, $namespace)) {
                throw new InvalidStreamModelException('Invalid stream. Attempted [' . $slug . ',' . $namespace . ']');
            }
        }

        $stream_fields = $stream->assignments;

        // @todo = This has to be redone as PSR
        return ci()->fields->set_rules($stream_fields, $method, $skips, true, $row_id);
    }

    /**
     * New stream collection
     *
     * @param  array $models
     * @return object
     */
    public function newCollection(array $models = array())
    {
        return new StreamCollection($models);
    }

    /**
     * Delete
     *
     * @return boolean
     */
    public function delete()
    {
        try {
            \Schema::dropIfExists($this->prefix . $this->slug);
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
     * Assign field
     *
     * @param  string $field
     * @param  mixed  $data
     * @return boolean
     */
    public function assignField(FieldModel $field = null, $data = array(), $createColumn = true)
    {
        // -------------------------------------
        // Get the field data
        // -------------------------------------

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

        // -------------------------------------
        // Load the field type
        // -------------------------------------

        /*        if (!$fieldType = $field->getType()) {
                    return false;
                }

                // Do we have a pre-add function?
                if (method_exists($fieldType, 'fieldAssignmentConstruct')) {
                    $fieldType->setStream($this);
                    $fieldType->fieldAssignmentConstruct();
                }

                // -------------------------------------
                // Create database column
                // -------------------------------------

                if ($this->fieldType->columnType !== false and $createColumn === true) {
                    with(new StreamSchemaColumnCreator($field))->createColumn();
                }*/

        // -------------------------------------
        // Check for title column
        // -------------------------------------
        // See if this should be made the title column
        // -------------------------------------

        if (isset($data['title_column']) and $data['title_column'] === true) {
            $update_data['title_column'] = $field->slug;

            $this->update($update_data);
        }

        // -------------------------------------
        // Create record in assignments
        // -------------------------------------

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
        $attributes['prefix'] = isset($attributes['prefix']) ? $attributes['prefix'] : $this->prefix;
        $attributes['slug']   = isset($attributes['slug']) ? $attributes['slug'] : $this->slug;

        $from = $this->prefix . $this->slug;
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
     * Add view option
     *
     * @param string $slug
     * @return bool
     */
    public function addViewOption($slug = null)
    {
        if (!$slug) {
            return false;
        }

        $view_options = $this->view_options;

        $view_options[] = $slug;

        $this->view_options = array_unique($view_options);

        $this->save();
    }

    public function save(array $options = array())
    {
        //$this->compileEntryModel();
        return parent::save($options);
    }

    /**
     * Compile entry model
     *
     * @return [type] [description]
     */
    public function compileEntryModel()
    {
        $generator = new EntryModelGenerator;
        return $generator->compile($this);
    }

    /**
     * Remove a field assignment
     *
     * @param    object
     * @param    object
     * @param    object
     * @return    bool
     */
    public function removeFieldAssignment($field)
    {
        if (!$field instanceof FieldModel) {
            return false;
        }

        // Do we have a destruct function
        if ($type = $field->getType()) {

            // @todo - also pass the schema builder
            $type->setStream($this);
            $type->fieldAssignmentDestruct();

            // -------------------------------------
            // Remove from db structure
            // -------------------------------------
            if (!$type->alt_process) {
                \Schema::table(
                    $this->prefix . $this->slug,
                    function ($table) use ($type, $schema) {
                        if (\Schema::hasColumn($table->getTable(), $type->getColumnName())) {
                            $table->dropColumn($type->getColumnName());
                        }
                    }
                );
            }
        }

        if ($fieldAssignment = FieldAssignmentModel::findByFieldIdAndStreamId($field->getKey(), $this->getKey())) {
            // -------------------------------------
            // Remove from field assignments table
            // -------------------------------------
            if (!$fieldAssignment->delete()) {
                return false;
            }
        }


        // -------------------------------------
        // Remove from from field options
        // -------------------------------------
        $this->removeViewOption($field->slug);

        return true;
    }

    /**
     * Remove view option
     *
     * @param string $slug
     * @return bool
     */
    public function removeViewOption($slug = null)
    {
        if (!$slug) {
            return false;
        }

        $view_options = $this->view_options;

        if (in_array($slug, $view_options)) {
            foreach ($view_options as $key => $view_option) {
                if ($slug == $view_option) {
                    unset($view_options[$key]);
                }
            }
        }

        $this->view_options = $view_options;

        $this->save();
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

    /**
     * Get entry model class
     *
     * @param $slug
     * @param $namespace
     * @return string
     */
    public static function getEntryModelClass($namespace, $slug)
    {
        return static::getEntryModelNamespace() . '\\' . Str::studly(
            "{$namespace}_{$slug}" . 'EntryModel'
        );
    }

    /**
     * Get entry model namespace
     *
     * @return string
     */
    public static function getEntryModelNamespace()
    {
        return 'Streams\\Model';
    }
}
