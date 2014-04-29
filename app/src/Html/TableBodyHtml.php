<?php namespace Streams\Html;

use Streams\Support\Fluent;

class TableBodyHtml extends Fluent
{
    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();

        $this
            ->onTableBodyCreate(
                function () {
                    return Element::create('thead');
                }
            )
            ->onTableBodyRowCreate(
                function () {
                    return Element::create('tr');
                }
            )
            ->onTableBodyCellCreate(
                function () {
                    return Element::create('th');
                }
            );
    }

    /**
     * On table body create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableBodyCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table body row create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableBodyRowCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table body cell create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableBodyCellCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}