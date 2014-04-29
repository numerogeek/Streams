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
        $table = 'Index';

        return \View::make('module.addons::admin/modules/index', compact('table'));
    }

    /**
     * Install a module.
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        if (!$module = \Module::get($slug)) {
            // Not found
        }

        if ($module and $module->install() and $module->installSchemas()) {
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
        if (!$module = \Module::get($slug)) {
            // Not found
        }

        if ($module and $module->uninstall() and $module->uninstallSchemas()) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::to('admin/addons/modules');
    }
}