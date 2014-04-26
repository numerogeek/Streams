<?php

// Public Routes
Route::get('/', 'Streams\Controller\PublicController@showWelcome');

// Authentication Filter
Route::filter(
    'authenticate',
    function () {
        $ignore = array('login', 'logout');

        if (!in_array(Request::segment(2), $ignore) and !Sentry::check()) {
            return Redirect::to('admin/login');
        }
    }
);

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