<?php namespace Streams\Exception;

class ClassNotInstanceOfEntryException extends Exception
{
    protected $message = 'The class is not an instance of Streams\EntryModel.';
}
