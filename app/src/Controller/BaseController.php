<?php namespace Streams\Controller;

class BaseController extends \Controller
{
    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->boot();
    }

    /**
     * Construct without bothering the parents.
     */
    public function boot()
    {
        // Nothing to do here..
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }

        $this->template = \App::make('streams.template');
    }
}
