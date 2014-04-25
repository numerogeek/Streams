<?php

Route::get('admin/test', 'Addon\Module\Test\Controller\Admin\TestController@index');

Route::get('admin/test/second', 'Addon\Module\Test\Controller\SecondController@index');