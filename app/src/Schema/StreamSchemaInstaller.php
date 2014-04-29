<?php namespace Streams\Schema;

use Streams\Addon\AddonAbstract;
use Streams\Contract\InstallerInterface;
use Streams\Model\FieldModel;
use Streams\Model\StreamModel;

class StreamSchemaInstaller implements InstallerInterface
{

    /**
     * The stream schema object
     *
     * @var StreamSchema
     */
    public $schema;

    /**
     * @var \Streams\Addon\AddonAbstract|null
     */
    public $addon;

    public function __construct(StreamSchema $schema, AddonAbstract $addon = null)
    {
        $this->schema = $schema;
        $this->addon  = $addon;
    }

    /**
     * Install
     *
     * @return bool
     */
    public function install()
    {
        $this->schema->onBeforeInstall();

        $streamData = array(
            'namespace'    => $this->schema->namespace,
            'slug'         => $this->schema->slug,
            'name'         => $this->schema->name,
            'description'  => $this->schema->description,
            'view_options' => $this->schema->viewOptions,
            'title_column' => $this->schema->titleColumn,
            'sort_by'      => $this->schema->sortBy,
            'menu_path'    => $this->schema->menuPath,
            'is_hidden'    => $this->schema->isHidden,
        );

        if ($this->addon) {

            $addonLang = $this->addon->addonType . '.' . $this->addon->slug . '::' . $this->schema->slug;

            $streamData['namespace'] = $this->schema->name ?: $this->addon->slug;

            if (!$this->schema->name) {
                $streamData['name'] = $addonLang . '.name';
            }

            if (!$this->schema->description) {
                $streamData['description'] = $addonLang . '.description';
            }
        }

        if ($stream = StreamModel::create($streamData)) {
            foreach ($this->schema->assignments() as $slug => $assignmentData) {
                if ($field = FieldModel::findBySlugAndNamespace($slug, $streamData['namespace'])) {
                    if ($assignment = $stream->assignField($field, $assignmentData)) {
                        if ($column = new StreamSchemaColumnCreator($assignment)) {
                            $column->createColumn();
                        }
                    }
                }
            }
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

        \StreamSchemaUtility::destroyNamespace($this->schema->namespace);

        $this->schema->onAfterUninstall();

        return true;
    }
}