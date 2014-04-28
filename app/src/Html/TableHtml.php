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
        $this->setAttribute('border', '1');

        $this->setHeaders($collection);
        $this->setRows($collection);
    }

    /**
     * Set the tables headers.
     *
     * @return $this|Table
     */
    public function setHeaders($items)
    {
        if (!$items) {
            return $this;
        }

        $headerClass = new $this->tableHeaderClass();

        $headers = $this->getHeaders($items);
        $thead   = $headerClass->fireOnCreateTableHeaderRow(Element::create('tr'), $items);

        foreach ($headers as $header) {
            $headerClass->fireOnCreateTableHeaderCell($thead, $header);
        }

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
     * Set the table's rows
     *
     * @param array $rows
     * @return self
     */
    public function setRows($items)
    {
        if (!$items) {
            return $this;
        }

        $bodyClass = new $this->tableBodyClass();

        $tbody = $bodyClass->fireOnCreateTableBody(Element::create('tbody'), $items);

        foreach ($items as $item) {
            $tr = $bodyClass->fireOnCreateTableRow(Element::create('tr'), $item);

            foreach ($this->getHeaders($items) as $header) {
                $tr->setChild($bodyClass->fireOnCreateTableCell(Element::create('td'), $header));
            }

            $tbody->setChild($tr);
        }

        $this->nest(
            array(
                'tbody' => $tbody,
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
