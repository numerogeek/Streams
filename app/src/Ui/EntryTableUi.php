<?php namespace Streams\Ui;

use Streams\Model\EntryModel;

class EntryTableUi extends EntryUiAbstract
{
    /**
     * The table entry class to use.
     *
     * @var string
     */
    protected $htmlClass = 'Streams\Html\EntryTableHtml';

    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Start process for rendering an entry table.
     *
     * @param      $slug
     * @param null $namespace
     * @return $this
     */
    public function table($slug, $namespace = null)
    {
        $this->triggerMethod = __FUNCTION__;

        if ($slug instanceof EntryModel) {
            $this->model = $slug;
        } else {
            $this->model = $this->getModelFromSlugAndNamespace($slug, $namespace);
        }

        return $this;
    }

    /**
     * Do the work for rendering a table..
     *
     * @return $this
     */
    protected function triggerTable()
    {
        if (!$this->entries) {
            $this->entries = $this->model->all();
        }

        $this->output = $this->html->table($this->entries)->render();

        return $this;
    }
}
