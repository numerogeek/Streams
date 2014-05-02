<?php namespace Addon\Module\Addons\Repository;

use Addon\Module\Addons\Contract\FieldTypeRepositoryInterface;
use Addon\Module\Addons\Model\FieldTypeEntryModel;
use Composer\Autoload\ClassLoader;

class StreamsFieldTypeRepository extends StreamsAddonRepositoryAbstract implements FieldTypeRepositoryInterface
{
    /**
     * Create a new StreamsFieldTypeRepository instance.
     */
    public function __construct()
    {
        $this->manager = \App::make('streams.field_types');
        $this->addons  = new FieldTypeEntryModel();
    }
}