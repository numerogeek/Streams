<?php namespace Addon\Module\Test\Schema;

use Streams\Schema\StreamSchema;

class TestStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'test';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'title' => array(),
            'foo' => array(),
            'bar' => array(),
        );
    }
}