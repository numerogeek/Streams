<?php namespace Streams\Html;

abstract class TableHtmlAbstract extends HtmlAbstract
{
    /**
     * The items to work with.
     *
     * @var array
     */
    protected $items = array();

    /**
     * Start process for rendering an entry table.
     *
     * @param      $slug
     * @param null $namespace
     * @return $this
     */
    public function table($items = null)
    {
        $this->triggerMethod = __FUNCTION__;

        if ($items) {
            $this->items = $items;
        }

        return $this;
    }

    /**
     * Do the work for rendering a table..
     *
     * @return $this
     */
    protected function triggerTable()
    {
        $this->output = 'POOPY TABLE';

        return $this;
    }
}
