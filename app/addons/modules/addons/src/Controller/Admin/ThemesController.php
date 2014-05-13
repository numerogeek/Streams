<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Contract\ThemeRepositoryInterface;
use Addon\Module\Addons\Model\ThemeEntryModel;
use Streams\Controller\AdminController;
use Streams\Ui\EntryTableUi;

class ThemesController extends AdminController
{
    /**
     * Create a new ThemesController instance.
     */
    public function __construct(ThemeRepositoryInterface $themes)
    {
        parent::__construct();

        $themes->sync();

        $this->table  = new EntryTableUi();
        $this->themes = new ThemeEntryModel();
    }

    /**
     * Display a table of all themes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->table->make($this->themes)->columns(array('id', 'slug', 'test column' => array('value' => 'Test')))->render();
    }
}