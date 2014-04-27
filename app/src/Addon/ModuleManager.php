<?php namespace Streams\Addon;

class ModuleManager extends AddonManagerAbstract
{
    protected $classSuffix = 'Module';

    /**
     * The folder within addons locations to load modules from.
     *
     * @var string
     */
    protected $folder = 'modules';
}
