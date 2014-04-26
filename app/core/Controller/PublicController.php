<?php namespace Streams\Controller;

class PublicController extends BaseController {

    /**
     * Show welcome
     *
     * @return mixed
     */
    public function showWelcome()
	{
		return \View::make('hello');
	}
}
