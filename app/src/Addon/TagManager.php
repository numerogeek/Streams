<?php namespace Streams\Addon;

class TagManager extends AddonManagerAbstract
{
    protected $classSuffix = 'Tag';

    /**
     * The folder within addons locations to load tags from.
     *
     * @var string
     */
    protected $folder = 'tags';
}
