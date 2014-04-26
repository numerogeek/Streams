<?php namespace Addon\Module\Test\Controller\Admin;

use Streams\Controller\AdminController;

class TestController extends AdminController
{
    public function index()
    {
        \Event::fire('test.test_event', null);

        return \View::make('module.test::index');
    }
}