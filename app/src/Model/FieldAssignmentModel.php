<?php namespace Streams\Model;

use Illuminate\Database\Query\Expression as DBExpression;
use Streams\Exception\FieldAssignmentModelNotFoundException;

class FieldAssignmentModel extends FieldModel
{
    /**
     * Collection class
     *
     * @var string
     */
    protected $collectionClass = 'Streams\Collection\FieldAssignmentCollection';

    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_fields_assignments';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Cleanup stale assignments for fields and streams that don't exists
     *
     * @return boolean
     */
    public static function cleanup()
    {
        $field_ids = FieldModel::all()->modelKeys();

        if (!$field_ids) {
            return true;
        }

        return static::whereNotIn('field_id', $field_ids)->delete();
    }

    /**
     * Get incremental sort order
     *
     * @param  integer $stream_id
     * @return integer
     */
    public static function getIncrementalSortNumber($stream_id = null)
    {
        $instance = new static;

        $top_num = $instance->getQuery()
            ->select(new DBExpression('MAX(sort_order) as top_num'))
            ->where('stream_id', $stream_id)
            ->pluck('top_num');

        return $top_num ? $top_num + 1 : 1;
    }

    /**
     * Find an assignment by field_id and stream_id.
     * 
     * @param null $fieldId
     * @param null $streamId
     * @param bool $fresh
     * @return mixed
     */
    public static function findByFieldIdAndStreamId($fieldId = null, $streamId = null, $fresh = false)
    {
        return static::where('field_id', $fieldId)
            ->where('stream_id', $streamId)
            ->take(1)
            ->first();
    }

    /**
     * Save the model
     *
     * @param  array $options
     * @return boolean
     */
    public function save(array $options = array())
    {
        $success = parent::save($options);

        // Save the stream so it re-compiles.
        $this->stream->save();

        return $success;
    }

    /**
     * Return the stream relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Streams\Model\StreamModel', 'stream_id');
    }

    /**
     * Return the field relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Streams\Model\FieldModel');
    }

    /**
     * Get type attribute
     *
     * @return mixed
     */
    public function getTypeAttribute()
    {
        return $this->field->type;
    }

    /**
     * Get slug attribute
     *
     * @return mixed
     */
    public function getSlugAttribute()
    {
        return $this->field->slug;
    }

    /**
     * Get settings attribute
     *
     * @return mixed
     */
    public function getSettingsAttribute()
    {
        return $this->field->slug;
    }
}
