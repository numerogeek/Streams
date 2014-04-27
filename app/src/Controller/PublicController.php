<?php namespace Streams\Controller;

class PublicController extends BaseController {

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
