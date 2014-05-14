<?php namespace Streams\Ui;

use Streams\Model\EntryModel;
use Streams\Traits\ButtonUiTrait;
use Streams\Traits\TableUiTrait;

class EntryTableUi extends EntryUiAbstract
{
    use TableUiTrait;
    use ButtonUiTrait;

    /**
     * Our streams model to render a table for.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The entries to render in the table.
     *
     * @var null
     */
    public $entries = null;

    /**
     * The title of the page / panel.
     *
     * @var null
     */
    public $title = null;

    /**
     * Show the table footer?
     *
     * @var bool
     */
    public $showFooter = true;

    /**
     * Show the table headers?
     *
     * @var bool
     */
    public $showHeaders = true;

    /**
     * Construct our class without bothering the parent.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Make an entry table.
     *
     * @param      $slug
     * @param null $namespace
     * @return $this
     */
    public function make($slug, $namespace = null)
    {
        $this->triggerMethod = 'table';

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
        // Get the columns and their configurable options.
        if (!$this->columns) {
            $this->columns = $this->getColumns();
        }

        // Get the entry data.
        if (!$this->entries) {
            $this->entries = $this->model->all();
        }

        // Finally prep the rows for the table.
        $this->rows = $this->getRows();

        $this->output = \View::make('streams/entry/table', get_object_vars($this));

        return $this;
    }

    /**
     * Set the title property.
     *
     * @param $title
     * @return $this
     */
    public function title($title)
    {
        $template = \App::make('streams.template');

        $template->title = $title;

        return $this;
    }

    /**
     * Set columns to display in the table.
     *
     * @param $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get columns from the stream.
     *
     * @return array
     */
    public function getColumns()
    {
        return array_flip($this->model->getStream()->view_options);
    }

    /**
     * Set button to display in the table.
     *
     * @param $buttons
     * @return $this
     */
    public function buttons(array $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Show the table footer?
     *
     * @param $show
     * @return $this
     */
    public function showFooter($show)
    {
        $this->showFooter = $show;

        return $this;
    }

    /**
     * Show the table headers?
     *
     * @param $show
     * @return $this
     */
    public function showHeaders($show)
    {
        $this->showHeaders = $show;

        return $this;
    }
}
