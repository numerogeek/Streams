<?php namespace Streams\Html;

use Streams\Support\Fluent;

class TableBodyHtml extends Fluent
{
    /**
     * Set up our default callback logic.
     */
    public function boot()
    {
        parent::boot();

        $this
            ->onCreateTableBody(
                function ($tbody, $items) {
                    return $tbody;
                }
            )
            ->onCreateTableRow(
                function ($tr, $items) {
                    return $tr;
                }
            )
            ->onCreateTableCell(
                function ($td, $value) {
                    return $td->nest('td', $value);
                }
            );
    }

    /**
     * Add a callback that fires when a table body is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableBodyHtml
     */
    public function onCreateTableBody(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Add a callback that fires when a table row is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableBodyHtml
     */
    public function onCreateTableRow(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Add a callback that fires when a table cell is being added.
     *
     * @param  Closure $callback
     * @return \Streams\Html\TableBodyHtml
     */
    public function onCreateTableCell(\Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
