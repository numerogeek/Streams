<?php namespace Streams\Ui;

use Streams\Model\EntryModel;

class EntryTableUi extends EntryUiAbstract
{
    /**
     * View options for our table.
     *
     * @var null
     */
    public $viewOptions = null;

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

        $columns = array('id') + array($this->model->getTitleColumn());

        $this->output = \View::make('streams/entry/table', array('columns' => $columns, 'entries' => $this->entries));

        return $this;
    }
}
