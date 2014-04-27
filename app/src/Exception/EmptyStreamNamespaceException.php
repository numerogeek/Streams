<?php namespace Streams\Exception;

class EmptyStreamNamespaceException extends Exception
{
    protected $message = 'The stream namespace property is empty.';
}
