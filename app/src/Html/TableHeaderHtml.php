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

        $this
            ->onCreateTableHeaderRow(
                function ($tr, $items) {
                    return $tr;
                }
            )
            ->onCreateTableHeaderCell(
                function ($th, $header) {
                    return $th->nest('th', $header);
                }
            );
    }

    /**
     * Add a callback that fires when a table header is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableHeaderHtml
     */
    public function onCreateTableHeader(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Add a callback that fires when a table header cell is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableHeaderHtml
     */
    public function onCreateTableHeaderCell(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
