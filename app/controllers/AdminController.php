<?php

class AdminController extends BaseController
{
    /**
     * Create a new AdminController instance
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the admin landing page
     */
    public function index()
    {
        echo 'Boom.';
    }
}
