<?php namespace Streams\Ui;

abstract class UiAbstract
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

        echo \View::make('blank', array('content' => $this->output));
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
