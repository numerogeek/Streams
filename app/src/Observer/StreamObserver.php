<?php namespace Streams\Observer;

use Streams\Entry\EntryModelGenerator;
use Streams\Model\FieldAssignmentModel;
use Streams\Model\FieldModel;
use Streams\Model\StreamModel;

class StreamObserver
{

    /**
     * Instantiate observer
     */
    public function __construct()
    {
        $this->generator = new EntryModelGenerator;
    }

    /**
     * Saved event
     *
     * @param StreamModel $model
     */
    public function saved(StreamModel $model)
    {
        //$this->generator->compile($model);
    }

    /**
     * Deleting event
     *
     * @param StreamModel $model
     * @return \Illuminate\Database\Schema\Blueprint
     */
    public function deleting(StreamModel $model)
    {
        return \Schema::dropIfExists($model->getEntryTable());
    }

    /**
     * Deleted event
     *
     * @param StreamModel $model
     */
    public function deleted(StreamModel $model)
    {
        FieldAssignmentModel::cleanup();
        FieldModel::cleanup();
    }

}