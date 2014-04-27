<?php namespace Streams\Exception;

class StreamSlugInUseException extends Exception
{
    protected $message = 'Stream slug is already in use.';
}
