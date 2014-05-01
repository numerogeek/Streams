<?php

/**
 * Public Routes
 */
Route::get('/', 'Streams\Controller\PublicController@hello');


/**
 * Installer Routes
 */
Route::get('installer/{step?}', 'Streams\Controller\InstallerController@run');


/**
 * Admin Routes
 */
Route::when('admin*', 'authenticate');  // Authenticate anything admin

// Login routes
Route::get('admin/login', 'Streams\Controller\AdminController@login');
Route::post('admin/login', 'Streams\Controller\AdminController@attemptLogin');

// Logout logic
Route::get(
    'admin/logout',
    function () {
        Sentry::logout();
        return Redirect::to('admin/login');
    }
);

// Default admin route
Route::get(
    'admin',
    function () {
        return Redirect::to('admin/dashboard');
    }
);
