<?php namespace Streams\Html;

use HtmlObject\Table;

class TableHtml extends Table
{
    /**
     * The table header class to use.
     *
     * @var string
     */
    protected $tableHeaderClass = 'Streams\Html\TableHeaderHtml';

    /**
     * The table body class to use.
     *
     * @var string
     */
    protected $tableBodyClass = 'Streams\Html\TableBodyHtml';

    /**
     * The table footer class to use.
     *
     * @var string
     */
    protected $tableFooterClass = 'Streams\Html\TableFooterHtml';

    /**
     * Create a new TableHtml instance.
     */
    public function __construct($collection)
    {
        $this->buildHeader($collection);
        //$this->rows($this->getRows());
    }

    /**
     * Build the table's header row.
     *
     * @return $this|Table
     */
    public function buildHeader($items)
    {
        if (!$items) {
            return $this;
        }

        $header = new $this->tableHeaderClass();

        $thead   = $header->fireOnCreateTableHeader(Element::create('tr'), $items);
        $headers = $this->getHeaders($items);

        foreach ($headers as $header) {
            $thead->nest('th', $header);
        }

        // Nest into table
        $this->nest(
            array(
                'thead' => Element::create('thead')->nest(
                        array(
                            'tr' => $thead,
                        )
                    ),
            )
        );

        return $this;
    }

    /**
     * Get the headers for the table's header row.
     *
     * @return array|null
     */
    protected function getHeaders($items)
    {
        if ($items) {
            return array_keys((array)$items->first());
        }

        return null;
    }
}
