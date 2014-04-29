<?php namespace Streams\Html;

use HtmlObject\Element;
use Streams\Support\Fluent;

class TableHtml extends Fluent
{
    /**
     * The table header HTML class to utilize.
     *
     * @var string
     */
    protected $tableHeaderHtmlClass = 'Streams\Html\TableHeaderHtml';

    /**
     * The table body HTML class to utilize.
     *
     * @var string
     */
    protected $tableBodyHtmlClass = 'Streams\Html\TableBodyHtml';

    /**
     * The table footer HTML class to utilize.
     *
     * @var string
     */
    protected $tableFooterHtmlClass = 'Streams\Html\TableFooterHtml';

    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();

        $this->thead = new $this->tableHeaderHtmlClass();
        $this->tbody = new $this->tableBodyHtmlClass();
        $this->tfoot = new $this->tableFooterHtmlClass();

        $this
            ->onTableCreate(
                function () {
                    return Element::create('table');
                }
            );
    }

    /**
     * Make a table the cool way.
     *
     * @param $models
     * @return $this
     */
    public function make($models)
    {
        // onTableCreate
        $table = $this->fireOnTableCreate();

        // onTableHeaderCreate
        $thead = $this->thead->onTableHeaderCreate();

        // onTableHeaderRowCreate
        // onTableHeaderCellCreate
        // onTableBodyCreate
        // onTableBodyRowCreate
        // onTableBodyCellCreate
        // onTableFooterCreate
        // onTableFooterRowCreate
        // onTableFooterCellCreate
    }

    /**
     * On table create callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function onTableCreate(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }
}
