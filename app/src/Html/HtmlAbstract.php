<?php namespace Streams\Html;

abstract class HtmlAbstract
{
    use \Streams\Traits\CallbacksTrait;
    use \Streams\Traits\AccessorMutatorTrait;

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
    public function render()
    {
        $this->{$this->getTriggerMethod()}();

        return $this->output;
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
}
