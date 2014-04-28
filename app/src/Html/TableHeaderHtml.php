<?php namespace Streams\Html;

use Streams\Support\Fluent;

class TableHeaderHtml extends Fluent
{
    /**
     * Set up our default callback logic.
     */
    public function boot()
    {
        parent::boot();

        $this->onCreateTableHeader(
            function ($tr, $items) {
                return $tr;
            }
        );
    }

    /**
     * Add a callback that fires when a table header is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableHtml
     */
    public function onCreateTableHeader(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
