<?php

use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {
        \Debug::measure('Load all field types.', function() {
               \FieldType::getAll();
            });

        return \Lang::get('module.users::messages.welcome');
    }
}