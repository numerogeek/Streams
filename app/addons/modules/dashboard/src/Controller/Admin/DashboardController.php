<?php namespace Addon\Module\Dashboard\Controller\Admin;

use Streams\Controller\AdminController;

class DashboardController extends AdminController
{
    public function index()
    {
        return $this->template->render('module.dashboard::index');
    }
}