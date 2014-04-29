<?php namespace Addon\Module\Test\Schema;

use Streams\Schema\FieldSchema;

class TestFieldSchema extends FieldSchema
{
    /**
     * Return an array of fields to install.
     *
     * @return array
     */
    public function fields()
    {
        return array(
            'title' => array(
                'type' => 'text',
                'settings' => array(
                    'default_value' => 'Hello there.',
                ),
            ),
            'foo' => array(
                'type' => 'choice',
                'settings' => array(
                    'default_value' => 'Hello there.',
                ),
            ),
            'bar' => array(
                'type' => 'textarea',
                'settings' => array(
                    'default_value' => 'Hello there.',
                ),
            ),
        );
    }
}