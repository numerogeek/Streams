<?php namespace Streams\Schema;

use Streams\Model\FieldAssignmentModel;
use Streams\Model\FieldModel;
use Streams\Model\StreamModel;

class StreamSchemaColumnCreator
{

    /**
     * Field assignment model
     *
     * @var \Streams\Model\FieldAssignmentModel
     */
    protected $fieldAssignment;

    /**
     * Get table.
     *
     * @return string
     */
    public function getTable(StreamModel $stream)
    {
        if (!$stream->prefix and $stream->prefix !== false) {
            $stream->prefix = $stream->namespace . '_';
        }

        return $stream->prefix . $stream->slug;
    }

    /**
     * Create the column
     *
     * @return boolean
     */
    public function createColumn(FieldModel $assignment)
    {
        // Check if the table exists
        if (!\Schema::hasTable($this->getTable($assignment->stream))) {
            return false;
        }

        $fieldType = $assignment->getType();

        // Check if the column does not exist already to avoid "duplicate column" errors
        if (\Schema::hasColumn(
            $this->getTable($assignment->stream),
            $fieldType->getColumnName($assignment)
        )
        ) {
            return false;
        }

        \Schema::table(
            $this->getTable($assignment->stream),
            function ($table) use ($assignment, $fieldType) {

                $columnTypeMethod = camel_case($fieldType->columnType);

                $column = $table->{$columnTypeMethod}($fieldType->getColumnName($assignment));

                $column->nullable();
            }
        );

        return true;
    }

}