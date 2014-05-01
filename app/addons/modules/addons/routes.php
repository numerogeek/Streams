<?php

// Go to modules by default
Route::get(
    'admin/addons',
    function () {
        return \Redirect::to('admin/addons/modules');
    }
);

// List all addons
Route::get('admin/addons/modules', 'Addon\Module\Addons\Controller\Admin\ModulesController@index');
Route::get('admin/addons/themes', 'Addon\Module\Addons\Controller\Admin\ThemesController@index');

// Install an addon
Route::get(
    'admin/addons/installer/install/{type}/{slug}',
    'Addon\Module\Addons\Controller\Admin\InstallerController@install'
);

Route::get(
    'admin/addons/installer/uninstall/{type}/{slug}',
    'Addon\Module\Addons\Controller\Admin\InstallerController@uninstall'
);