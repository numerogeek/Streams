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

                $column = $table->{$columnTypeMethod}($this->fieldType->getColumnName());

                /**
                 * Default Value
                 */
                $defaultValue = $this->fieldAssignment->getSetting('default_value');

                if ($defaultValue and !in_array(
                        $columnTypeMethod,
                        array('text', 'longText')
                    )
                ) {
                    $column->default($defaultValue);
                }

                /**
                 * Allow null by default
                 */

                $column->nullable();
            }
        );

        return true;
    }

}