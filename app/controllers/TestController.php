<?php

use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {
/*        \Debug::measure('Load all field types.', function() {
               \FieldType::getAll();
            });

        \Streams\Model\StreamModel::create(array(
                'namespace' => 'dogs',
                'slug' => 'dogs',
            ));*/

        \Module::installSchemas('test');

        return 'Test!';
    }
}