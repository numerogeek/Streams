<?php namespace Streams\Traits;

trait CallbacksTrait
{
    /**
     * Registered callbacks.
     *
     * @var array
     */
    protected $callbacks = array();

    /**
     * Register a callback.
     *
     * @param $method
     * @param $callable
     * @return $this
     */
    public function addCallback($method, \Closure $callable)
    {
        $this->callbacks[\Str::studly($method)] = $callable;

        return $this;
    }

    /**
     * Trigger a callback.
     *
     * @internal param $method
     * @internal param null $arguments
     * @return mixed|null
     */
    public function triggerCallback()
    {
        $arguments = func_get_args();

        $method = \Str::studly($arguments[0]);

        if (isset($this->callbacks[$method])) {
            return call_user_func_array($this->callbacks[$method], array_splice($arguments, 1));
        }

        return null;
    }
}