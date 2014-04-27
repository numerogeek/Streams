<?php namespace Streams\Exception;

class FieldSlugInUseException extends Exception
{
    protected $message = 'The Field slug is already in use for this namespace.';
}
