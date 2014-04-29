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