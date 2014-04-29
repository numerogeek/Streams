<?php namespace Streams\Html;

use HtmlObject\Element;
use Illuminate\Support\Fluent;

class TableFooterHtml extends Fluent
{
    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();

        $this
            ->onTableFooterCreate(
                function () {
                    return Element::create('thead');
                }
            )
            ->onTableFooterRowCreate(
                function () {
                    return Element::create('tr');
                }
            )
            ->onTableFooterCellCreate(
                function () {
                    return Element::create('th');
                }
            );
    }

    /**
     * On table footer create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableFooterCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table footer row create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableFooterRowCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table footer cell create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableFooterCellCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
