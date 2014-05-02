<?php

Route::get(
    'admin/dashboard',
    function () {
        return \Template::render('module.dashboard::test');
    }
);
