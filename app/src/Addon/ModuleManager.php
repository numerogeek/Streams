<?php namespace Streams\Addon;

class ModuleManager extends AddonManagerAbstract
{
    /**
     * The folder within addons locations to load modules from.
     *
     * @var string
     */
    protected $folder = 'modules';

    public function install($slug)
    {
        if ($module = $this->get($slug)) {



        }

        return true;
    }
}
