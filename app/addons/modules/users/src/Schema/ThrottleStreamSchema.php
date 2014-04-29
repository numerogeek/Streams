<?php namespace Addon\Module\Users\Schema;

use Streams\Schema\StreamSchema;

class ThrottleStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'throttle';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'user'            => array('is_required' => true),
            'ip_address'      => array('is_required' => true),
            'attempts'        => array('is_required' => true),
            'suspended'       => array('is_required' => true),
            'banned'          => array('is_required' => true),
            'last_attempt_at' => array(),
            'suspended_at'    => array(),
            'banned_at'       => array(),
        );
    }
}