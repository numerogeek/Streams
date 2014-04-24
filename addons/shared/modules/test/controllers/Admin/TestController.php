<?php namespace Addon\Module\Test\Controller\Admin;

class TestController extends \AdminController
{
    public function index()
    {
        return \View::make('TestModule::index');
    }
}