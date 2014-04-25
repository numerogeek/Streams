<?php namespace App\Addon\FieldType;

use App\Addon\AddonServiceProviderAbstract;

class FieldTypeServiceProvider extends AddonServiceProviderAbstract
{
    /**
     * The manager class to use.
     *
     * @var string
     */
    protected $managerClass = 'App\Addon\FieldType\FieldTypeManager';
}
