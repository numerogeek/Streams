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
     * Render the current trigger method.
     *
     * @param bool $return
     * @return mixed
     */
    public function render($return = false)
    {
        $this->{$this->getTriggerMethod()}();

        if ($return) {
            return \View::make('html/panel', array('content' => $this->output));
        }

        echo \Template::render('html/panel', array('content' => $this->output));
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
