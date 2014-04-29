<?php namespace Streams\Schema;

use Streams\Contract\InstallerInterface;

class SchemaTypeManager
{

    /**
     * Array of schema type classes
     *
     * @var array
     */
    protected $schemaTypes = array();

    public function __construct($schemaTypes)
    {
        if (is_string($schemaTypes)) {
            $this->schemaTypes = array($schemaTypes);
        } else {
            if (is_array($schemaTypes)) {
                $this->schemaTypes = $schemaTypes;
            }
        }
    }

    /**
     * Install
     *
     * @return bool|mixed
     */
    public function install()
    {
        $success = true;

        foreach ($this->schemaTypes as $schemaTypeClass) {
            $schemaType = new $schemaTypeClass;
            if ($schemaType instanceof SchemaTypeAbstract) {
                $installer = $schemaType->getInstaller();
                if ($installer instanceof InstallerInterface) {
                    if (!$installer->install()) {
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }

    /**
     * Uninstall
     *
     * @return bool|mixed
     */
    public function uninstall()
    {
        $success = true;

        foreach ($this->schemaTypes as $schemaTypeClass) {
            $schemaType = new $schemaTypeClass;
            if ($schemaType instanceof SchemaTypeAbstract) {
                $installer = $schemaType->getInstaller();
                if ($installer instanceof InstallerInterface) {
                    if (!$installer->uninstall()) {
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }

}