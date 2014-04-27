<?php namespace Streams\Addon;

class BlockManager extends AddonManagerAbstract
{
    protected $classSuffix = 'Block';

    /**
     * The folder within addons locations to load blocks from.
     *
     * @var string
     */
    protected $folder = 'blocks';
}
