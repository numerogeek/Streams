<?php namespace Streams\Model;

use Illuminate\Support\Str;
use Streams\Exception\EmptyFieldNamespaceException;
use Streams\Exception\EmptyFieldSlugException;
use Streams\Exception\FieldModelNotFoundException;
use Streams\Exception\InvalidFieldTypeException;

class FieldModel extends EloquentModel
{
    /**
     * FieldAssignmentCollection
     *
     * @var string
     */
    protected $collectionClass = 'Streams\Collection\FieldCollection';

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
     * Enable or disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Find a field by slug and namespace.
     *
     * @param null $slug
     * @param null $namespace
     * @return mixed
     */
    public static function findBySlugAndNamespace($slug = null, $namespace = null)
    {
        return static::where('slug', $slug)
            ->where('namespace', $namespace)
            ->take(1)
            ->first();
    }

    /**
     * Find fields by namespace
     *
     * @param $namespace
     * @return mixed
     */
    public function findByNamespace($namespace)
    {
        return $this->where('namespace', $namespace)->sortBy('slug')->get();
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
     * Cleanup stale fields that have no assignments.
     *
     * @return bool
     */
    public static function cleanup()
    {
        $ids = FieldAssignmentModel::all()->getFieldIds();

        if (!$ids) {
            return true;
        }

        return static::whereNotIn('id', $ids)->delete();
    }

    /**
     * Get the corresponding field type instance.
     *
     * @param null $entry
     * @return \AddonAbstract|bool
     */
    public function getType($entry = null)
    {
        if (!$fieldType = \FieldType::get($this->type)) {
            return false;
        }

        return $fieldType;
    }

    /**
     * Get a field setting value.
     *
     * @param      $key
     * @param null $defaultValue
     * @return null
     */
    public function getSetting($key, $defaultValue = null)
    {
        return isset($this->settings->{$key}) ? $this->settings->{$key} : $defaultValue;
    }

    /**
     * Delete a field and it will delete it's assignments.
     *
     * @param   int
     * @return  bool
     */
    public function delete()
    {
        return (parent::delete() === true and FieldAssignmentModel::cleanup());
    }

    /**
     * Get field name attribute.
     *
     * @param $name
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
     * Set field data attribute.
     *
     * @param array $settings
     */
    public function setSettingsAttribute($settings)
    {
        if (is_array($settings)) {

            // Allow a chance to return values in Closures.
            foreach ($settings as &$value) {
                $value = value($value);
            }

            $this->attributes['settings'] = json_encode($settings);
        } else {
            $this->attributes['settings'] = $settings;
        }
    }

    /**
     * Return the decoded settings attribute.
     *
     * @param $settings
     * @return mixed
     */
    public function getSettingsAttribute($settings)
    {
        if (is_string($settings)) {
            return json_decode($settings);
        }

        return $settings;
    }

    /**
     * Return the assignments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany('Streams\Model\FieldAssignmentModel', 'field_id');
    }
}
