<?php namespace Addon\Module\Test\Controller\Admin;

class TestController extends \AdminController
{
    public function index()
    {
        \Event::fire('test.test_event', null);

        return \View::make('TestModule::index');
    }
}