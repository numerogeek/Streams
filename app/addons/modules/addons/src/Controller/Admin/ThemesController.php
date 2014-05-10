<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Model\ThemeEntryModel;
use Streams\Controller\AdminController;
use Addon\Module\Addons\Contract\ThemeRepositoryInterface;
use Streams\Ui\EntryTableUi;

class ThemesController extends AdminController
{
    /**
     * Create a new ThemesController instance.
     *
     * @param \Streams\Addon\ThemeManager $modules
     */
    public function __construct(ThemeRepositoryInterface $modules)
    {
        parent::__construct();

        $this->modules = $modules;

        $this->modules->sync();

        $this->ui    = new EntryTableUi();
        $this->model = new ThemeEntryModel();
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