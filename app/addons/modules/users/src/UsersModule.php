<?php namespace Addon\Module\Users;

use Streams\Addon\ModuleAbstract;

class UsersModule extends ModuleAbstract
{
    /*******************************************
     * REMOVE AFTER INSTALLED IS FINISHED!
     *******************************************/
    public function install()
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
