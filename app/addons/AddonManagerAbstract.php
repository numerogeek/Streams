<?php namespace App\Addons;

use Illuminate\Support\Str;

abstract class AddonManagerAbstract
{
    /**
     * Make the addon
     *
     * @param $path
     * @return \stdClass
     */
    public function make($path)
    {
        require $path.'/details.php';

        $class = Str::studly(basename($path)).'Module';

        $addon = new $class;

        $addon->path = $path;
        $addon->slug = basename($path);

        return $addon;
    }
}