<?php namespace Addon\Module\Users\Model;

use Cartalyst\Sentry\Users\Eloquent\User;

class UserModel extends User
{
    /**
     * Override the table used.
     *
     * @var string
     */
    public $table = 'users_users';
}
