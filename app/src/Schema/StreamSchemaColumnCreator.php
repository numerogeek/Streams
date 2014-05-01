<?php namespace Streams\Schema;

use Streams\Addon\FieldTypeAbstract;
use Streams\Model\FieldAssignmentModel;
use Streams\Model\FieldModel;

class StreamSchemaColumnCreator
{

    /**
     * Create the column
     *
     * @return boolean
     */
    public function createColumn(FieldModel $assignment)
    {
        $entryTable = $assignment->stream->getEntryTable();

        // Check if the table exists
        if (!\Schema::hasTable($entryTable)) {
            return false;
        }

        $fieldType = $assignment->field->getType();

        $columnName = $fieldType->getColumnName($assignment->field);

        // Check if the column does not exist already to avoid "duplicate column" errors
        if (\Schema::hasColumn($entryTable, $columnName)) {
            return false;
        }

        \Schema::table(
            $assignment->stream->getEntryTable(),
            function ($entryTable) use ($assignment, $fieldType, $columnName) {

                // This is the Schema Blueprint method we'll be using
                $columnTypeMethod = camel_case($fieldType->columnType);

                // Get the column constraint if any
                $constraint = $this->getColumnConstraint($assignment);

                // Only the string method cares about a constraint
                if ($columnTypeMethod === 'string' and $constraint) {
                    $column = $entryTable->{$columnTypeMethod}($columnName, $constraint);
                } else {
                    $column = $entryTable->{$columnTypeMethod}($columnName);
                }

                // Save a default value in the table schema
                $column->default($assignment->field->getSetting('default_value'));

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

        $maxLength = $assignment->field->getSetting('max_length');
        $fieldType = $assignment->field->getType();

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