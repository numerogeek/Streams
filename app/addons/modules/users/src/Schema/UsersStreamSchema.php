<?php namespace Addon\Module\Users\Schema;

use Streams\Schema\StreamSchema;

class UsersStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'users';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'email'               => array('is_required' => true, 'is_unique' => true),
            'password'            => array('is_required' => true),
            'permissions'         => array(),
            'is_activated'        => array('is_required' => true),
            'activation_code'     => array(),
            'activated_at'        => array(),
            'last_login'          => array(),
            'persist_code'        => array(),
            'reset_password_code' => array(),
            'first_name'          => array(),
            'last_name'           => array(),
        );
    }

    /*******************************************
     * REMOVE AFTER INSTALLED IS FINISHED!
     *******************************************/
    public function onAfterInstall()
    {
        // Create a user
        \Sentry::createUser(
            array(
                'email'     => 'test@domain.com',
                'password'  => 'password',
                'is_activated' => true,
            )
        );

        return true;
    }
    /*******************************************
     * EOF: REMOVE AFTER INSTALLED IS FINISHED!
     *******************************************/
}