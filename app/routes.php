<?php



// Public Routes
Route::get('/', 'Streams\Controller\PublicController@showWelcome');
Route::get('installer/{step?}', 'Streams\Controller\InstallerController@run');

Route::when('admin*', 'authenticate');

// Admin Routes
Route::get('admin', 'Streams\Controller\AdminController@index');
Route::get(
    'admin/logout',
    function () {
        Sentry::logout();
        return Redirect::to('admin/login');
    }
);

Route::get('admin/login', 'Streams\Controller\AdminController@login');
Route::post('admin/login', 'Streams\Controller\AdminController@attemptLogin');