<?php namespace Streams\Handler;

class FieldTypeHandler
{

    /**
     * Get valid relation methods
     *
     * @return array
     */
    public function getValidRelationMethods()
    {
        return array(
            'hasOne',
            'morphOne',
            'belongsTo',
            'morphTo',
            'hasMany',
            'morphMany',
            'belongsToMany',
            'morphToMany',
        );
    }

    /**
     * Has relation
     *
     * @return boolean
     */
    public function hasRelation(FieldTypeAbstract $fieldType)
    {
        if (method_exists($fieldType, 'relation')) {
            $relationArray = $fieldType->relation();

            if (!is_array($relationArray) or empty($relationArray)) {
                return false;
            }

            if (!empty($relationArray['method']) and in_array(
                    $relationArray['method'],
                    $this->getValidRelationMethods()
                )
            ) {
                return true;
            }
        }
    }

    /**
     * Wrapper method for the Eloquent hasOne method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphOne method
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsTo($related, $foreignKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphTo() method
     *
     * @param  string $name
     * @param  string $type
     * @param  string $id
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function morphTo($name = null, $type = null, $id = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent hasMany() method
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasMany($related, $foreignKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent morphMany() method
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method
     *
     * @param  EntryModel $related
     * @param  string     $table
     * @param  string     $foreignKey
     * @param  string     $otherKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param  string $related
     * @param  string $name
     * @param  string $table
     * @param  string $foreignKey
     * @param  string $otherKey
     * @param  bool   $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
    {
        return array(
            'method'     => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

}