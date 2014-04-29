<?php namespace Streams\Schema;

use Streams\Addon\FieldTypeAbstract;
use Streams\Model\FieldAssignmentModel;

class StreamSchemaColumnCreator
{

    /**
     * Field assignment model
     *
     * @var \Streams\Model\FieldAssignmentModel
     */
    protected $fieldAssignment;

    public function __construct(FieldAssignmentModel $fieldAssignment)
    {
        $this->fieldAssignment = $fieldAssignment;
        $this->fieldType       = $fieldAssignment->getType();
        $this->stream          = $fieldAssignment->stream;
    }

    public function getTable()
    {
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
        if (\Schema::hasColumn($this->getTable(), $this->fieldtype->getColumnName())) {
            return false;
        }

        \Schema::table(
            $this->getTable(),
            function ($table) {

                $columnTypeMethod = camel_case($this->fieldType->columnType);

                // -------------------------------------
                // Constraint
                // -------------------------------------
                $constraint = 255;

                $maxLength = $this->fieldAssignment->getSetting('max_length');

                // First we check and see if a constraint has been added
                if ($this->fieldType instanceof FieldTypeAbstract and
                    isset($this->fieldType->columnConstraint) and $this->fieldType->columnConstraint
                ) {
                    $constraint = $type->columnConstraint;

                    // Otherwise, we'll check for a max_length field
                } elseif (is_numeric($maxLength)
                ) {
                    $constraint = $maxLength;
                }

                // Only the string method cares about a constraint
                if ($columnTypeMethod === 'string') {
                    $column = $table->{$columnTypeMethod}($this->fieldType->getColumnName(), $constraint);
                } else {
                    $column = $table->{$columnTypeMethod}($this->fieldType->getColumnName());
                }

                // -------------------------------------
                // Default
                // -------------------------------------
                $defaultValue = $this->fieldAssignment->getSetting('default_value');

                if ($defaultValue and !in_array(
                        $columnTypeMethod,
                        array('text', 'longText')
                    )
                ) {
                    $column->default($defaultValue);
                }

                // -------------------------------------
                // Default to allow null
                // -------------------------------------

                $column->nullable();
            }
        );

        return true;
    }

}