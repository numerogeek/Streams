<?php namespace Addon\Module\Addons\Controller\Admin;

use Streams\Controller\AdminController;
use Addon\Module\Addons\Contract\ModuleRepositoryInterface;

class ModulesController extends AdminController
{
    /**
     * Create a new ModulesController instance.
     *
     * @param \Streams\Addon\ModuleManager $modules
     */
    public function __construct(ModuleRepositoryInterface $modules)
    {
        parent::__construct();

        $this->modules = $modules;
    }

    /**
     * Display a table of all modules.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $modules = \Module::getAll();

        $this->modules->sync();

        return \View::make('module.addons::admin/modules/index', compact('modules'));
    }
}