<?php namespace Addon\Module\Addons\Schema;

use Streams\Schema\StreamSchema;

class BlocksStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'blocks';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'slug' => array(),
            'is_installed' => array(),
            'is_enabled' => array(),
        );
    }
}