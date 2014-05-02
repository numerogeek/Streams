<?php namespace Addon\Module\Addons\Contract;

interface AddonRepositoryInterface
{
    public function sync();
    public function all();
}