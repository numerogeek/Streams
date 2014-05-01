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

    /**
     * Install a theme.
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        if (\Theme::install($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::to('admin/addons/themes');
    }

    /**
     * Uninstall a theme.
     *
     * @param $slug
     * @return bool
     */
    public function uninstall($slug)
    {
        if (\Theme::uninstall($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::to('admin/addons/themes');
    }
}