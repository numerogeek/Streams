<?php namespace Streams\Schema;

use Streams\Addon\AddonAbstract;
use Streams\Contract\InstallerInterface;
use Streams\Model\FieldAssignmentModel;
use Streams\Model\FieldModel;
use Streams\Traits\InstallableEventsTrait;

class FieldSchemaInstaller implements InstallerInterface
{
    use InstallableEventsTrait;

    /**
     * The field schema object
     *
     * @var FieldSchema
     */
    public $schema;

    /**
     * @var \Streams\Addon\AddonAbstract|null
     */
    public $addon;

    public function __construct(FieldSchema $schema, AddonAbstract $addon = null)
    {
        $this->fields = new FieldModel;
        $this->assignments = new FieldAssignmentModel;

        // Default namespace
        $schema->namespace = $schema->namespace ? : $addon->slug;

        $this->schema = $schema;
        $this->addon  = $addon;
    }

    /**
     * Install
     *
     * @return mixed
     */
    public function install()
    {
        $this->schema->onBeforeInstall();

        foreach ($this->schema->fields() as $slug => $fieldData) {

            if ($this->addon) {

                $fieldData['slug'] = $slug;

                $fieldData['namespace'] = $this->schema->namespace;

                $addonLang = $this->addon->type . '.' . $fieldData['namespace'] . '::fields.' . $slug;

                $fieldData['name'] = isset($fieldData['name']) ? $fieldData['name'] : $addonLang . '.name';

                $fieldData['is_locked'] = isset($fieldData['is_locked']) ? $fieldData['is_locked'] : true;
            }

            $this->fields->create($fieldData);
        }

        $this->schema->onAfterInstall();

        return true;
    }

    /**
     * Uninstall
     *
     * @return mixed
     */
    public function uninstall()
    {
        $this->schema->onBeforeUninstall();
        
        $this->fields->deleteByNamespace($this->schema->namespace);
        $this->assignments->cleanup();
        $this->fields->cleanup();

        $this->schema->onAfterUninstall();

        return true;
    }
}