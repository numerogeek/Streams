<?php namespace User\Module\Users\Controller\Admin;

use Streams\Controller\AdminController;

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
        $table = 'Index';

        return \View::make('module.users::admin/modules/index', compact('table'));
    }
}