<?php

// Public Routes
Route::get('/', 'PublicController@showWelcome');

// Admin Routes
Route::get('/admin', 'AdminController@index');