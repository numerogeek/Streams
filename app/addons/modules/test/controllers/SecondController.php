<?php namespace Addon\Module\Test\Controller;

use Streams\Controller\AdminController;

class SecondController extends AdminController
{
    public function index()
    {
        echo 'I am another controller!';
    }
}