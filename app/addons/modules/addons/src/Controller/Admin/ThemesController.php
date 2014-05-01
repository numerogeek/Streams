<?php namespace Addon\Module\Addons\Controller\Admin;

use Streams\Controller\AdminController;
use Addon\Module\Addons\Contract\ThemeRepositoryInterface;

class ThemesController extends AdminController
{
    /**
     * Create a new ThemesController instance.
     *
     * @param \Streams\Addon\ThemeManager $themes
     */
    public function __construct(ThemeRepositoryInterface $themes)
    {
        parent::__construct();

        $this->themes = $themes;
    }

    /**
     * Display a table of all themes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $themes = \Theme::getAll();

        $this->themes->sync();

        return \View::make('module.addons::admin/themes/index', compact('themes'));
    }
}