<?php namespace Addon\Module\Addons\Controller\Admin;

use Streams\Controller\AdminController;

class InstallerController extends AdminController
{
    /**
     * Install an addon.
     *
     * @param $type
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function install($type, $slug)
    {
        $manager = '\\' . \Str::studly($type);

        if ($manager::install($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::back();
    }

    /**
     * Uninstall an addon.
     *
     * @param $type
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uninstall($type, $slug)
    {
        $manager = '\\' . \Str::studly($type);

        if ($manager::install($slug)) {
            // Great
        } else {
            // Something went wrong - check logs
        }

        return \Redirect::back();
    }
}