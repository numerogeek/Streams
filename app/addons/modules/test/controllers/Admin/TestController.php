<?php namespace Addon\Module\Test\Controller\Admin;

use Streams\Controller\PublicController;

class TestController extends PublicController
{
    public function index()
    {
        echo 'Oh hai!';
    }
}