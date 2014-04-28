<?php namespace Addon\Module\Users\Controller\Admin;

use Streams\Controller\AdminController;
use Streams\Html\TableHtml;

class AddonsController extends AdminController
{
    /**
     * Display a table of modules
     *
     * @return \Illuminate\View\View|void
     */
    public function index()
    {
        $modules = \Module::getAll();
        $table   = new TableHtml($modules);

        return \View::make('module.addons::admin/modules/index', compact('table'));
    }
}