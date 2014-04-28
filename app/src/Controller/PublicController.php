<?php namespace Streams\Controller;

class PublicController extends BaseController
{
    /**
     * Create a new PublicController instance
     */
    public function __construct()
    {
        if (\Request::segment(1) !== null) {
            \Module::get(strtolower(\Request::segment(1)));
        }
    }

    /**
     * Hello
     *
     * @return mixed
     */
    public function hello()
	{
		return \View::make('hello');
	}
}
