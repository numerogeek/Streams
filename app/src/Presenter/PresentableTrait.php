<?php namespace Streams\Presenter;

trait PresentableTrait
{


    /**
     * Set presenter class
     *
     * @return object
     */
    public function setPresenterClass($presenterClass = null)
    {
        $this->presenterClass = $presenterClass;

        return $this;
    }

    /**
     * Get presenter
     *
     * @Return Streams\Presenter\BasePresenter|Streams\Model\Eloquent
     */
    public function getPresenter()
    {
        $decorator = new BasePresenterDecorator;

        return $decorator->decorate($this);
    }

    /**
     * Get presenter class
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return $this->presenterClass;
    }
}