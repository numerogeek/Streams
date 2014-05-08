<?php namespace Streams\Helper;

class EntryHelper
{
    /**
     * Get an entry model class.
     *
     * @param $stream_slug
     * @param $stream_namespace
     * @return mixed
     */
    public function getModelClass($slug, $namespace)
    {
        return \Str::studly("Streams\Model\\_{$namespace}\\_{$namespace}_{$slug}_EntryModel");
    }
}