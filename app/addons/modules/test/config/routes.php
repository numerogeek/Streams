<?php

Route::get('admin/test', 'App\Addons\Modules\Test\TestController@index');
Route::get('admin/test/dump', 'App\Addons\Modules\Test\TestController@dump');

Route::get('admin/test/second', 'App\Addons\Modules\Test\SecondController@index');