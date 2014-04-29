<?php namespace Addon\Module\Users\Schema;

use Streams\Schema\StreamSchema;

class GroupsStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'groups';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'name'        => array('is_required' => true, 'is_unique' => true),
            'permissions' => array(),
        );
    }
}