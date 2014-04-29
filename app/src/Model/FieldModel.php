<?php namespace Streams\Model;

use Illuminate\Support\Str;
use Streams\Exception\EmptyFieldNamespaceException;
use Streams\Exception\EmptyFieldSlugException;
use Streams\Exception\FieldModelNotFoundException;
use Streams\Exception\InvalidFieldModelException;
use Streams\Exception\InvalidFieldTypeException;
use Streams\Exception\InvalidStreamModelException;

class FieldModel extends EloquentModel
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_fields';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * FieldAssignmentCollection
     *
     * @var string
     */
    protected $collectionClass = 'Streams\Collection\FieldCollection';

    /**
     * Stream
     *
     * @var object
     */
    protected $_stream = null;

    /**
     * Type
     *
     * @var null
     */
    protected $_type = null;

    /**
     * Add fields
     *
     * @param array  $fields             The array of fields
     * @param string $assign_slug The optional stream slug to assign all fields. Avoids the need to add it individually.
     * @param string $namespace          The optional namespace for all fields. Avoids the need to add it individually.
     * @return bool
     */
    public static function addFields($fields = array(), $assign_slug = null, $namespace = null)
    {
        if (empty($fields)) {
            return false;
        }

        $success = true;

        foreach ($fields as $field) {
            if ($assign_slug) {
                $field['assign'] = $assign_slug;
            }

            if ($namespace) {
                $field['namespace'] = $namespace;
            }

            if (!static::addField($field)) {
                $success = false;
            }
        }

        return $success;
    }

    public static function create(array $attributes = array())
    {
        if (!$attributes['slug'] and $attributes['namespace']) {
            return false;
        }

        if (!$field = static::findBySlugAndNamespace($attributes['slug'], $attributes['namespace'])) {
            $field = parent::create($attributes);
        }

        return $field;
    }

    /**
     * Add field
     *
     * @param   array - settings
     * @return  object|bool
     */
    public static function addField($field)
    {
        $namespace = null;
        $slug = null;

        extract($field);

        // -------------------------------------
        // Validate Data
        // -------------------------------------

        // Do we have a field name?
        if (!isset($name) or !trim($name)) {
            $name = "{$namespace}.field.{$slug}.name";
        }

        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        // Is this stream slug already available?
        if ($field = static::findBySlugAndNamespace($slug, $namespace)) {
            /*            log_message(
                            'debug',
                            'The Field slug is already in use for this namespace. Attempted [' . $slug . ',' . $namespace . ']'
                        );*/

            return false;
        }

        // Is this a valid field type?
        if (!isset($type) or !\FieldType::get($type)) {
            throw new InvalidFieldTypeException('Invalid field type. Attempted [' . $type . ']');
        }

        // Set is_locked
        $isLocked = (isset($is_locked) and $is_locked === true) ? 'yes' : 'no';

        // Set extra
        if (!isset($extra) or !is_array($extra)) {
            $extra = array();
        }

        // -------------------------------------
        // Create Field
        // -------------------------------------

        $attributes = array(
            'name'       => $name,
            'slug' => $slug,
            'type' => $type,
            'namespace'  => $namespace,
            'settings'   => $extra,
            'is_locked'  => $isLocked
        );

        if (!$field = static::create($attributes)) {
            return false;
        }

        // -------------------------------------
        // Assignment (Optional)
        // -------------------------------------

        if (isset($assign) and $assign != '' and $stream = StreamModel::findBySlugAndNamespace(
                $assign,
                $namespace,
                true
            )
        ) {
            $data = array();

            // Title column
            $data['title_column'] = isset($title_column) ? $title_column : false;

            // Instructions
            $data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;

            // Is Unique
            $data['is_unique'] = isset($is_unique) ? $is_unique : false;

            // Is Required
            $data['is_required'] = isset($is_required) ? $is_required : false;

            // Add actual assignment
            return $stream->assignField($field, $data);
        }

        return $field;
    }

    /**
     * Get a single field by the field slug
     *
     * @param   string field slug
     * @param   string field namespace
     * @return  object
     */
    public static function findBySlugAndNamespace($slug = null, $namespace = null)
    {
        return static::where('slug', $slug)
            ->where('namespace', $namespace)
            ->take(1)
            ->first();
    }

    /**
     * Assign field to stream
     *
     * @param   string - namespace
     * @param   string - stream slug
     * @param   string - field slug
     * @param   array  - assign data
     * @return  mixed - false or assignment ID
     */
    public static function assignField($slug, $namespace, $slug, $assign_data = array())
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------
        if (!$field = static::findBySlugAndNamespace($slug, $namespace)) {
            throw new InvalidFieldModelException('Invalid field slug. Attempted [' . $slug . ']');
        }

        if ($stream = StreamModel::findBySlugAndNamespaceOrFail($slug, $namespace)) {
            // -------------------------------------
            // Assign Field
            // -------------------------------------

            // Add actual assignment
            return $stream->assignField($field, $assign_data);
        }

        return false;
    }

    /**
     * De-assign field
     * This also removes the actual column
     * from the database.
     *
     * @param   string - namespace
     * @param   string - stream slug
     * @param   string - field slug
     * @return  bool
     */
    public static function deassignField($namespace, $slug, $slug)
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------

        if (!$stream = StreamModel::findBySlugAndNamespace($slug, $namespace)) {
            throw new InvalidStreamModelException('Invalid stream slug. Attempted [' . $slug . ',' . $namespace . ']');
        }

        if (!$field = static::findBySlugAndNamespace($slug, $namespace)) {
            throw new InvalidFieldModelException('Invalid field slug. Attempted [' . $slug . ']');
        }

        // -------------------------------------
        // De-assign Field
        // -------------------------------------

        return $stream->removeFieldAssignment($field);
    }

    /**
     * Delete field
     *
     * @param   string - field slug
     * @param   string - field namespace
     * @return  bool
     */
    public static function deleteField($slug, $namespace)
    {
        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        if (!$field = static::findBySlugAndNamespace($slug, $namespace)) {
            return false;
        }

        return $field->delete();
    }

    /**
     * Update field
     *
     * @param   string - slug
     * @param   array  - new data
     * @return  bool
     */
    public static function updateField(
        $slug,
        $namespace,
        $name = null,
        $type = null,
        $settings = array()
    ) {
        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        // Find the field by slug and namespace or throw an exception
        if (!$field = static::findBySlugAndNamespace($slug, $namespace)) {
            return false;
        }

        // Is this a valid field type?
        if (isset($type) and !\FieldType::get($type)) {
            throw new InvalidFieldTypeException('Invalid field type. Attempted [' . $type . ']');
        }

        return $field->update($settings);
    }

    /**
     * Get assigned fields for
     * a stream.
     *
     * @param   string - field slug
     * @param   string - namespace
     * @return  object
     */
    public static function getFieldAssignments($slug, $namespace)
    {
        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            throw new EmptyFieldSlugException;
        }

        if (!$field = static::findBySlugAndNamespace($slug, $namespace)) {
            return false;
        }

        return $field->assignments;
    }

    /**
     * Insert a field
     *
     * @param   string - the field name
     * @param   string - the field slug
     * @param   string - the field type
     * @param   [array - any extra data]
     * @return  bool
     */
    // $name, $slug, $type, $namespace, $extra = array(), $isLocked = 'no'
    /**
     * Tear down assignment + field combo
     * Usually we'd just delete the assignment,
     * but we need to delete the field as well since
     * there is a 1-1 relationship here.
     *
     * @param   int  - assignment id
     * @param   bool - force delete field, even if it is shared with multiple streams
     * @return  bool - success/fail
     */
    public static function teardownFieldAssignment($assign_id, $force_delete = false)
    {
        // Get the assignment
        if ($assignment = FieldAssignmentModel::find($assign_id)) {
            // Get stream
            if (!$stream = $assignment->stream) {
                return false;
            }

            // Get field
            if (!$field = $assignment->field) {
                return false;
            }

            // Delete the assignment
            $stream->removeFieldAssignment($field);

            // Remove the field only if unlocked and has no assingments
            if (!$field->is_locked or $field->assignments->isEmpty() or $force_delete) {
                // Remove the field
                return $field->delete();
            }
        }
    }

    /**
     * Count fields
     *
     * @return int
     */
    public static function countByNamespace($namespace = null)
    {
        if (!$namespace) {
            return 0;
        }

        return static::where('namespace', $namespace)->count();
    }

    /**
     * Cleanup stale fields that have no assignments
     *
     * @return [type] [description]
     */
    public static function cleanup()
    {
        $field_ids = FieldAssignmentModel::all()->getFieldIds();

        if (!$field_ids) {
            return true;
        }

        return static::whereNotIn('id', $field_ids)->delete();
    }

    /**
     * Delete fields by namespace
     *
     * @param  string $namespace
     * @return object
     */
    public static function deleteByNamespace($namespace)
    {
        return static::where('namespace', $namespace)->delete();
    }

    /**
     * Find by slug and namespace (or false)
     *
     * @param  string $slug
     * @param  string $namespace
     * @return mixed                  Object or false if none found
     */
    public static function findBySlugAndNamespaceOrFail($slug = null, $namespace = null)
    {
        if (!is_null($model = static::findBySlugAndNamespace($slug, $namespace))) {
            return $model;
        }

        throw new FieldModelNotFoundException;
    }

    /**
     * Find many by namespace
     *
     * @param  string  $namespace
     * @param  integer $limit
     * @param  integer $offset
     * @param  array   $skips
     * @return array
     */
    public static function findManyByNamespace(
        $namespace = null,
        $limit = null,
        $offset = null,
        array $skips = null
    ) {
        $query = static::where('namespace', '=', $namespace);

        if (!empty($skips)) {
            $query = $query->whereNotIn('slug', $skips);
        }

        if ($limit > 0) {
            $query = $query->take($limit)->skip($offset);
        }

        return $query->get();
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Streams\static|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new FieldModelNotFoundException;
    }

    /**
     * Get field options.
     *
     * @param array $skips
     * @return mixed
     */
    public static function getFieldOptions($skips = array())
    {
        if (is_string($skips)) {
            $skips = array($skips);
        }

        if (!empty($skips)) {
            return static::whereNotIn('slug', $skips)->lists('name', 'id');
        } else {
            return static::lists('name', 'id');
        }
    }

    /**
     * Get field namespace options
     *
     * @return array
     */
    public static function getFieldNamespaceOptions()
    {
        return static::all()->getFieldNamespaceOptions();
    }

    /**
     * Save
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $attributes = $this->getAttributes();

        // Load the type to see if there are other params
/*        if ($fieldType = $this->getType()) {
            $fieldType->setPreSaveParameters($attributes);

            foreach ($fieldType->getCustomParameters() as $setting) {
                if (method_exists(
                        $fieldType,
                        Str::studly('param_' . $setting . '_pre_save')
                    ) and $value = $fieldType->getPreSaveParameter($setting)
                ) {
                    $attributes['settings'][$setting] = $fieldType->{Str::studly('param_' . $setting . '_pre_save')}($value);
                }
            }
        }*/

        return parent::save($options);
    }

    /**
     * Get the corresponding field type instance
     *
     * @param  [type] $entry [description]
     * @return [type]        [description]
     */
    public function getType($entry = null)
    {
        if (!$fieldType = \FieldType::get($this->type)) {
            return false;
        }

        return $fieldType;
    }

    /**
     * Get setting
     *
     * @param      $key
     * @param null $defaultValue
     * @return null
     */
    public function getSetting($key, $defaultValue = null)
    {
        return isset($this->settings[$key]) ? $this->settings[$key] : $defaultValue;
    }

    /**
     * Update field
     *
     * @param   obj
     * @param   array - data
     * @param   int
     */
    public function update(array $attributes = array())
    {
        $fieldType = $this->getType();

        // -------------------------------------
        // Alter Columns
        // -------------------------------------
        // We want to change columns if the
        // following change:
        //
        // * Field Type
        // * Field Slug
        // * Max Length
        // * Default Value
        // -------------------------------------

        // Eager load assignments with their related stream
        $this->load('assignments.stream');

        $assignments = $this->getAttribute('assignments');

        $settings = $this->settings;

        $attributes['slug'] = isset($attributes['slug']) ? $attributes['slug'] : null;

        $from = $slug;
        $to   = $attributes['slug'];

        if (
            (isset($attributes['type']) and $this->type != $attributes['type']) or
            (isset($attributes['slug']) and $this->slug != $attributes['slug']) or
            (isset($this->settings['max_length']) and $this->settings['max_length'] != $attributes['max_length']) or
            (isset($this->settings['default_value']) and $this->settings['default_value'] != $attributes['default_value'])
        ) {
            // If so, we need to update some table columns
            // Get the field assignments and change the table names

            // Check first to see if there are any assignments
            if (!$assignments->isEmpty()) {

                foreach ($assignments as $assignment) {
                    if (!method_exists($fieldType, 'altRenameColumn')) {
                        if ($to and $from != $to) {
                            \Schema::table(
                                $assignment->stream->prefix . $assignment->stream->slug,
                                function ($table) use ($from, $to) {
                                    $table->renameColumn($from, $to);
                                }
                            );
                        }
                    }

                    if ($assignment->stream and isset($assignment->stream->view_options[$slug])) {
                        $assignment->stream->view_options[$slug] = $attributes['slug'];
                        $assignment->stream->save();
                    }
                }

                // Run though alt rename column routines. Needs to be done
                // after the above loop through assignments.
                foreach ($assignments as $assignment) {
                    if (method_exists($fieldType, 'altRenameColumn')) {
                        // We run a different function for alt_process
                        $fieldType->altRenameColumn($this, $assignment->stream, $assignment);
                    }
                }
            }
        }

        // Run edit field update hook
        if (method_exists($fieldType, 'updateField')) {
            $fieldType->updateField($this, $assignments);
        }

        // Gather extra data
        foreach ($fieldType->getCustomSettings() as $setting) {
            $settingMethod =  'setting' . Str::studly($setting) . 'PreSave';
            if (method_exists($fieldType, $settingMethod)) {
                $settings[$setting] = $fieldType->{$settingMethod}($this);
            }
        }

        $attributes['settings'] = $settings;

        if (parent::update($attributes)) {
            if (!$assignments->isEmpty() and $to and $from != $to) {
                StreamModel::updateTitleColumnByStreamIds($assignments->getStreamIds(), $from, $to);
            }

            return true;
        } else {
            // Boo.
            return false;
        }
    }

    /**
     * Delete a field
     *
     * @param   int
     * @return  bool
     */
    public function delete()
    {
        if ($success = parent::delete()) {
            // Find assignments, and delete rows from table
            if ($assignments = $this->getAttribute('assignments') and !$assignments->isEmpty()) {
                // Delete assignments
                FieldAssignmentModel::cleanup();
                // Reset instances where the title column
                // is the field we are deleting. PyroStreams will
                // always just use the ID in place of the field.

                $title_column = $this->getAttribute('slug');

                StreamModel::updateTitleColumnByStreamIds($assignments->getStreamIds(), $title_column);
            }
        }

        return $success;
    }

    /**
     * Get the field
     *
     * @return object
     */
    public function getParameter($key, $default = null)
    {
        $settingeter = isset($this->settings[$key]) ? $this->settings[$key] : $default;

        // Check for empty string
        if (empty($settingeter)) {
            return null;
        }

        return $settingeter;
    }

    /**
     * assignments
     *
     * @return boolean
     */
    public function assignments()
    {
        return $this->hasMany('Streams\Model\FieldAssignmentModel', 'field_id');
    }

    /**
     * Get field name attr
     *
     * @param  string $name
     * @return string
     */
    public function getFieldNameAttribute($name)
    {
        // This guarantees that the language will be loaded
        \FieldType::get($this->type);

        $name = trans($name);

        if (empty($name)) {
            $name = trans($name);
        }

        return $name;
    }

    /**
     * Set field data attr
     *
     * @param array $settings
     */
    public function setSettingsAttribute($settings)
    {
        if (is_array($settings)) {

            /**
             * Allow a chance to return values in Closures
             */
            foreach ($settings as &$value) {
                $value = value($value);
            }

            $this->attributes['settings'] = json_encode($settings);
        } else {
            $this->attributes['settings'] = $settings;
        }
    }

    /**
     * Get field data attr
     *
     * @param  string $settings
     * @return array
     */
    public function getSettingsAttribute($settings)
    {
        if (is_string($settings)) {
            return json_decode($settings);
        }

        return $settings;
    }

}
