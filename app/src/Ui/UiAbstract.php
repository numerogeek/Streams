<?php namespace Streams\Ui;

abstract class UiAbstract
{
    use \Streams\Traits\CallbacksTrait;

    /**
     * The method to trigger with render.
     *
     * @var null
     */
    protected $triggerMethod = null;

    /**
     * The output of the UI.
     *
     * @var null
     */
    protected $output = null;

    /**
     * The model we are working with.
     *
     * @var null
     */
    protected $model = null;

    /**
     * Runtime cache.
     *
     * @var array
     */
    protected $cache = array();

    /**
     * Render the current trigger method.
     *
     * @param bool $return
     * @return mixed
     */
    public function render($return = false)
    {
        $this->{$this->getTriggerMethod()}();

        if ($return) {
            return $this->output;
        }

        //echo 'RENDER ME: ' . $this->output;
    }

    /**
     * Return the trigger method attribute.
     *
     * @return null
     */
    protected function getTriggerMethod()
    {
        return \Str::studly('trigger_' . $this->triggerMethod);
    }

    /**
     * Set a property value.
     *
     * @param $property
     * @param $value
     * @return $this
     */
    public function set($property, $value)
    {
        $this->{$property} = $value;

        return $this;
    }

    /**
     * Get a property value.
     *
     * @param $property
     * @param $default
     * @return mixed
     */
    public function get($property, $default)
    {
        return isset($this->{$property}) ? $this->{$property} : $default;
    }
}
