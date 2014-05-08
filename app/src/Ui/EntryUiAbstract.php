<?php namespace Streams\Ui;

abstract class EntryUiAbstract extends UiAbstract
{
    /**
     * The entries we have to work with.
     *
     * @var null
     */
    public $entries = null;

    /**
     * Create a new EntryUiAbstract instance.
     */
    public function __construct()
    {
        $this->html = new $this->htmlClass;

        $this->boot();
    }

    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
    }

    /**
     * Override the entries used for the UI method.
     *
     * @param null $entries
     * @return $this
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get a model from slug and namespace.
     *
     * @param      $slug
     * @param null $namespace
     * @return mixed
     */
    protected function getModelFromSlugAndNamespace($slug, $namespace = null)
    {
        if (!$namespace) {
            $class = $slug;
        } else {
            $class = \EntryHelper::getModelClass($slug, $namespace);
        }

        return new $class;
    }
}
