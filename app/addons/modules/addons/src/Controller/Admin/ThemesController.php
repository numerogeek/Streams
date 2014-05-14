<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Model\ThemeEntryModel;
use Streams\Controller\AdminController;
use Streams\Ui\EntryTableUi;

class ThemesController extends AdminController
{
    /**
     * Construct without bothering the parents.
     */
    public function boot()
    {
        $this->table  = new EntryTableUi();
        $this->themes = new ThemeEntryModel();

        $this->themes->sync();
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