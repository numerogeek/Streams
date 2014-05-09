<?php namespace Addon\Module\Dashboard\Controller\Admin;

use Streams\Controller\AdminController;
use Streams\Ui\EntryTableUi;

class DashboardController extends AdminController
{
    public function index()
    {
        $ui = new EntryTableUi();
        $model = new \Streams\Model\Addons\AddonsModulesEntryModel;

        $ui->table($model)->render();
    }
}