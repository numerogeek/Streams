<?php namespace Streams\Helper;

class CacheHelper
{
    /**
     * Get a cache key from God knows what someone passes in.
     *
     * @param $shit
     * @return string
     */
    public function getKey($shit)
    {
        ob_start();
        var_dump($shit);
        $string = ob_get_clean();

        return md5($string);
    }
}