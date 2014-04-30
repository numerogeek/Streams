<?php namespace Addon\Module\Users\Schema;

use Streams\Schema\FieldSchema;

class UsersFieldSchema extends FieldSchema
{
    /**
     * Return an array of fields to install.
     *
     * @return array
     */
    public function fields()
    {
        return array(
            'email'               => array(
                'type' => 'email',
            ),
            'password'            => array(
                'type' => 'text',
            ),
            'permissions'         => array(
                'type' => 'textarea',
            ),
            'is_activated'        => array(
                'type' => 'boolean',
            ),
            'activation_code'     => array(
                'type' => 'text',
            ),
            'activated_at'        => array(
                'type' => 'datetime',
            ),
            'last_login'          => array(
                'type' => 'datetime',
            ),
            'persist_code'        => array(
                'type' => 'text',
            ),
            'reset_password_code' => array(
                'type' => 'text',
            ),
            'first_name'          => array(
                'type' => 'text',
            ),
            'last_name'           => array(
                'type' => 'text',
            ),
            'groups'              => array(
                'type'     => 'multiple',
                'settings' => array(
                    'relation' => 'Addon\Module\Users\Model\GroupEntryModel',
                ),
            ),
            'name'                => array(
                'type' => 'text',
            ),
            'user'                => array(
                'type'     => 'relationship',
                'settings' => array(
                    'relation' => 'Addon\Module\Users\Model\UserEntryModel',
                ),
            ),
            'group'               => array(
                'type'     => 'relationship',
                'settings' => array(
                    'relation' => 'Addon\Module\Users\Model\GroupEntryModel',
                ),
            ),
            'ip_address'          => array(
                'type' => 'text',
            ),
            'attempts'            => array(
                'type' => 'integer',
            ),
            'suspended'           => array(
                'type' => 'boolean',
            ),
            'banned'              => array(
                'type' => 'boolean',
            ),
            'last_attempt_at'     => array(
                'type' => 'datetime',
            ),
            'suspended_at'        => array(
                'type' => 'datetime',
            ),
            'banned_at'           => array(
                'type' => 'datetime',
            ),
        );
    }
}