<?php namespace Addon\Module\Users\Controller\Admin;

use Streams\Controller\AdminController;

class UsersController extends AdminController
{
    public function index()
    {
        return \View::make('module.users::index');
    }
}