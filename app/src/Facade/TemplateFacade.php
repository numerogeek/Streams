<?php namespace Streams\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class TemplateFacade extends BaseFacade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'streams.template';
    }

}