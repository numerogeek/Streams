<?php namespace Streams\Html;

use HtmlObject\Element;
use Streams\Support\Fluent;

class TableHeaderHtml extends Fluent
{
    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();

        $this
            ->onTableHeaderCreate(
                function () {
                    return Element::create('thead');
                }
            )
            ->onTableHeaderRowCreate(
                function () {
                    return Element::create('tr');
                }
            )
            ->onTableHeaderCellCreate(
                function () {
                    return Element::create('th');
                }
            );
    }

    /**
     * On table header create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableHeaderCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table header row create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableHeaderRowCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table header cell create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableHeaderCellCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
