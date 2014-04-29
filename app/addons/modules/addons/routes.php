<?php

// Go to modules by default
Route::get(
    'admin/addons',
    function () {
        return \Redirect::to('admin/addons/modules');
    }
);

// List all modules
Route::get('admin/addons/modules', 'Addon\Module\Addons\Controller\Admin\ModulesController@index');

// Install a module
Route::get('admin/addons/modules/install/{slug}', 'Addon\Module\Addons\Controller\Admin\ModulesController@install');
Route::get('admin/addons/modules/uninstall/{slug}', 'Addon\Module\Addons\Controller\Admin\ModulesController@uninstall');