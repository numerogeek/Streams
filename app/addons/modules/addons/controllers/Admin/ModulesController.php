<?php namespace Addon\Module\Addons\Controller\Admin;

use Streams\Controller\AdminController;
use Streams\Html\TableHtml;

class ModulesController extends AdminController
{
    /**
     * Create a new ModulesController instance.
     *
     * @param \Streams\Addon\ModuleManager $modules
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a table of all modules.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $modules = \FieldType::getAll();

        $table = new TableHtml($modules);

        return \View::make('module.addons::admin/modules/index', compact('table'));
    }

    /**
     * Install a module
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        \Module::install($slug);

        \Redirect::to('/');
    }
}