<?php namespace App\Addons\Modules;

use App\Addons\AddonsServiceProviderAbstract;

class ModuleServiceProvider extends AddonsServiceProviderAbstract
{
    /**
     * Type
     *
     * @var string
     */
    protected $type = 'modules';

    public function boot()
    {
        parent::boot('test');
        parent::register('test');
    }
}