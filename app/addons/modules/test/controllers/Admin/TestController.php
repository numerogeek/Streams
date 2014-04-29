<?php namespace Addon\Module\Test\Controller\Admin;

use Streams\Controller\AdminController;

class TestController extends AdminController
{
    public function index()
    {
        echo 'Oh hai!';
    }
}