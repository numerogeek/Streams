<?php namespace Addon\Module\Addons\Controller\Admin;

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
        $modules = \Module::getAll();

        return \View::make('module.addons::admin/modules/index', compact('modules'));
    }

    /**
     * Install a module.
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        if (\Module::install($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::to('admin/addons/modules');
    }

    /**
     * Uninstall a module.
     *
     * @param $slug
     * @return bool
     */
    public function uninstall($slug)
    {
        if (\Module::uninstall($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::to('admin/addons/modules');
    }
}