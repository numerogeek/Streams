<?php namespace Addon\Module\Addons\Schema;

use Streams\Schema\FieldSchema;

class AddonsFieldSchema extends FieldSchema
{
    /**
     * Return an array of fields to install.
     *
     * @return array
     */
    public function fields()
    {
        return array(
            'slug' => array(
                'field_type' => 'text',
            ),
            'is_installed' => array(
                'field_type' => 'boolean',
            ),
            'is_enabled' => array(
                'field_type' => 'boolean',
            ),
        );
    }
}