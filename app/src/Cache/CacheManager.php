<?php namespace Streams\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Cache\RedisStore;
use Illuminate\Filesystem\Filesystem;

class CacheManager extends \Illuminate\Cache\CacheManager
{
    /**
     * Create an instance of the file cache driver.
     *
     * @return \Illuminate\Cache\FileStore
     */
    protected function createFileDriver()
    {
        $path = $this->app['config']['cache.path'];

        return $this->repository(new FileStore(new Filesystem, $path));
    }

    /**
     * Create an instance of the Redis cache driver.
     *
     * @return \Illuminate\Cache\RedisStore
     */
    protected function createRedisDriver()
    {
        $servers = $this->app['config']['redis'];

        return $this->repository(new RedisStore(new RedisDatabase($servers), $this->getPrefix()));
    }


    /**
     * Get a cache collection of keys or set the keys to be indexed.
     * @todo - can this be split into two methods? "or" throws a flag for me
     *
     * @param  string $collectionKey
     * @param  array  $keys
     * @return object
     */
    public function collection($collectionKey, $keys = array())
    {
        if (is_string($keys)) {
            $keys = array($keys);
        }

        if ($cached = ci()->cache->get($collectionKey) and is_array($cached)) {
            $keys = array_merge($keys, $cached);
        }

        $collection = CacheCollection::make($keys);

        return $collection->setKey($collectionKey);
    }

    /**
     * Is cache enabled?
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return (bool)$this->app['config']['cache.enable'];
    }
}
