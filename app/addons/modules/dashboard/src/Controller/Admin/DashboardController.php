<?php namespace Addon\Module\Dashboard\Controller\Admin;

use Streams\Controller\AdminController;
use Streams\Ui\EntryTableUi;

class DashboardController extends AdminController
{
    public function index()
    {
        $ui = new EntryTableUi();
        $model = new \Streams\Model\Addons\AddonsModulesEntryModel;

        $table = $ui->table($model)->render(true);

        return $this->template->render('module.dashboard::test', compact('table'));
    }
}