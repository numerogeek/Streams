<?php

Route::get(
    'admin/addons',
    function () {
        return \Redirect::to('admin/addons/modules');
    }
);

Route::get('admin/addons', 'Addon\Module\Addons\Controller\Admin\ModulesController@index');