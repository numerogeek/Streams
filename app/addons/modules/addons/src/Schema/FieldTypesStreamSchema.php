<?php namespace Addon\Module\Addons\Schema;

use Streams\Schema\StreamSchema;

class FieldTypesStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'field_types';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'slug' => array(
                'is_required' => true
            ),
            'is_installed' => array(
                'is_required' => true
            ),
            'is_enabled' => array(
                'is_required' => true
            ),
        );
    }
}