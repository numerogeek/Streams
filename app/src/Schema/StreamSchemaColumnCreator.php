<?php namespace Streams\Schema;

use Streams\Model\FieldAssignmentModel;

class StreamSchemaColumnCreator
{

    /**
     * Field assignment model
     *
     * @var \Streams\Model\FieldAssignmentModel
     */
    protected $fieldAssignment;

    /**
     * Create a new instance with basic field information.
     *
     * @param FieldAssignmentModel $fieldAssignment
     */
    public function __construct(FieldAssignmentModel $fieldAssignment)
    {
        $this->fieldAssignment = $fieldAssignment;
        $this->fieldType       = $fieldAssignment->getType();
        $this->stream          = $fieldAssignment->stream;
    }

    /**
     * Get table.
     *
     * @return string
     */
    public function getTable()
    {
        if (!$this->stream->prefix and $this->stream->prefix !== false) {
            $this->stream->prefix = $this->stream->namespace . '_';
        }

        return $this->stream->prefix . $this->stream->slug;
    }

    /**
     * Create the column
     *
     * @return boolean
     */
    public function createColumn()
    {
        // Check if the table exists
        if (!\Schema::hasTable($this->getTable())) {
            return false;
        }

        // Check if the column does not exist already to avoid "duplicate column" errors
        if (\Schema::hasColumn($this->getTable(), $this->fieldType->getColumnName())) {
            return false;
        }

        \Schema::table(
            $this->getTable(),
            function ($table) {

                $columnTypeMethod = camel_case($this->fieldType->columnType);

                $column = $table->{$columnTypeMethod}($this->fieldType->getColumnName());

                $column->nullable();
            }
        );

        return true;
    }

}