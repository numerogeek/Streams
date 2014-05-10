<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Model\ModuleEntryModel;
use Streams\Controller\AdminController;
use Addon\Module\Addons\Contract\ModuleRepositoryInterface;
use Streams\Ui\EntryTableUi;

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

        $this->modules->sync();

        $this->ui    = new EntryTableUi();
        $this->model = new ModuleEntryModel();
    }

    /**
     * Display a table of all modules.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->ui->table($this->model)->render();
    }
}