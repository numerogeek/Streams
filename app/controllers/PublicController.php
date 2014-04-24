<?php

class PublicController extends BaseController {

    /**
     * Show welcome
     *
     * @return mixed
     */
    public function showWelcome()
	{
		return View::make('hello');
	}
}
