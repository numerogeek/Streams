<?php namespace Streams\Addon;

class ExtensionManager extends AddonManagerAbstract
{
    protected $classSuffix = 'Extension';

    /**
     * The folder within addons locations to load extensions from.
     *
     * @var string
     */
    protected $folder = 'extensions';
}
