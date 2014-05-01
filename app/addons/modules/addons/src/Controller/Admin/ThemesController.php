<?php namespace Addon\Module\Addons\Controller\Admin;

use Streams\Controller\AdminController;

class ThemesController extends AdminController
{
    /**
     * Create a new ThemesController instance.
     *
     * @param \Streams\Addon\ThemeManager $themes
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a table of all themes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $themes = \Theme::sync();

        return \View::make('module.addons::admin/themes/index', compact('themes'));
    }
}