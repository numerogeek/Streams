<?php namespace Streams\Traits;

trait TableUiTrait
{
    /**
     * Column to for the table.
     *
     * @var null
     */
    public $columns = null;

    /**
     * Get prepared rows for the view.
     *
     * @param $columns
     * @param $entries
     * @return array
     */
    protected function getRows()
    {
        $this->setColumnDefaults($this->columns);

        $rows = array();

        foreach ($this->entries as $entry) {

            $row = array(
                'data'   => array(), // The column value.
                'column' => array(), // The td attributes.
                'row'    => null, // The tr attributes.
            );

            // Process buttons
            if ($this->buttons) {
                $row['buttons'] = $this->getRowButtons($entry);
            }

            // This will is the column / row value.
            foreach ($this->columns as $column => $options) {
                $row['data'][$column]   = $this->getRowColumnData($column, $options, $entry);
                $row['column'][$column] = null;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Set the defaults per column.
     *
     * @param $columns
     */
    protected function setColumnDefaults(&$columns)
    {
        $defaults = array();

        // First make sure columns have a header.
        foreach ($columns as $column => $options) {
            if (is_string($options) and $column = $options) {
                $defaults[$column] = array();
            } else {
                $defaults[$column] = $options;
            }

            // Options must be an array.
            if (!is_array($options)) {
                $defaults[$column] = array();
            }

            // Default to a sensible header.
            if (!isset($options['header'])) {
                $defaults[$column]['header'] = \Str::studly($column);

                // Translate the header if applicable
            } elseif (strpos($options['header'], '::') !== false) {
                $defaults[$column]['header'] = trans($options['header']);
            }

            // No buttons by default.
            if (!isset($options['buttons'])) {
                $defaults[$column]['buttons'] = null;
            }
        }

        $columns = $defaults;

        unset($defaults);
    }

    /**
     * Get the column data of a row.
     *
     * @param $column
     * @param $options
     * @param $entry
     * @return string
     */
    protected function getRowColumnData($column, $options, $entry)
    {
        // Is there a rule for the value being passed along?
        if (isset($options['data'])) {

            // Check if the value is a closure.
            if (is_callable($options['data'])) {
                return call_user_func($options['data'], $entry);

                // If it's a string - parse it out.
            } elseif (is_string($options['data'])) {
                return 'PARSED: ' . $options['header'] . ' - ' . $options['data'];
            }

            // Generate the value the ol' fashioned way.
        } elseif (isset($entry->{$column})) {
            return $entry->{$column};
        }

        return null;
    }
}
