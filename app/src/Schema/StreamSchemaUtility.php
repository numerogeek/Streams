<?php namespace Streams\Schema;

use Streams\Model\FieldAssignmentModel;
use Streams\Model\FieldModel;
use Streams\Model\StreamModel;

class StreamSchemaUtility
{
    /**
     * Remove Namespace
     *
     * Performs all uninstall actions for a specific
     * namespace.
     *
     * @param	string - namespace
     * @return	bool
     */
    public function destroyNamespace($namespace)
    {
        // Some field destructs use stream data from the cache,
        // so let's make sure that the slug cache has run.

        foreach(StreamModel::findManyByNamespace($namespace) as $stream) {
            $stream->delete();
        }

        // Make sure that garbage is collected even it the stream is not present anymore
        FieldModel::deleteByNamespace($namespace);
        FieldAssignmentModel::cleanup();
        FieldModel::cleanup();

        // Remove all fields in namespace
        return true;
    }
}