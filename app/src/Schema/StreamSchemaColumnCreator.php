<?php namespace Streams\Schema;

use Streams\Addon\FieldTypeAbstract;
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

                // This is the Eloquent method we'll be using
                $columnTypeMethod = camel_case($fieldType->columnType);

                // Get the column constraint if any
                $constraint = $this->getColumnConstraint($assignment);

                // Only the string method cares about a constraint
                if ($columnTypeMethod === 'string' and $constraint) {
                    $column = $table->{$columnTypeMethod}($fieldType->getColumnName($assignment), $constraint);
                } else {
                    $column = $table->{$columnTypeMethod}($fieldType->getColumnName($assignment));
                }

                // Save a default value in the table schema
                $column->default($assignment->getSetting('default_value'));

                // Mirror requirements on the table
                $column->nullable(!$assignment->is_required);
            }
        );

        return true;
    }

    /**
     * Get the column constraint for an assignment.
     *
     * @param $assignment
     * @return int|string
     */
    protected function getColumnConstraint(FieldAssignmentModel $assignment)
    {
        $constraint = 255;

        $maxLength = $assignment->getSetting('max_length');
        $fieldType = $assignment->getType();

        // First we check and see if a constraint has been added
        if ($fieldType instanceof FieldTypeAbstract and
            isset($fieldType->columnConstraint) and $fieldType->columnConstraint
        ) {
            $constraint = $fieldType->columnConstraint;

            // Otherwise, we'll check for a max_length field
        } elseif (is_numeric($maxLength)
        ) {
            $constraint = $maxLength;
        }

        return $constraint;
    }
}