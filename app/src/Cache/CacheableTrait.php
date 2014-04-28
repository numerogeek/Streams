<?php namespace Streams\Cache;

trait CacheableTrait
{
    /**
     * Cache minutes
     *
     * @var integer|boolean
     */
    protected $cacheMinutes = false;

    /**
     * Get a cache collection of keys or set the keys to be indexed.
     * @todo - can this be split into two methods? "or" throws a flag for me
     *
     * @param  string $collectionKey
     * @param  array  $keys
     * @return object
     */
    public function cacheCollection($collectionKey, $keys = array())
    {
        if (is_string($keys)) {
            $keys = array($keys);
        }

        if ($cached = \Cache::get($collectionKey) and is_array($cached)) {
            $keys = array_merge($keys, $cached);
        }

        $collection = CacheCollection::make($keys);

        return $collection->setKey($collectionKey);
    }

    /**
     * Flush cache collection
     *
     * @return Pyro\Model\Eloquent
     */
    public function flushCacheCollection()
    {
        $this->cacheCollection($this->getCacheCollectionKey())->flush();

        return $this;
    }

    /**
     * Get cache collection key
     *
     * @return string
     */
    public function getCacheCollectionKey($suffix = null)
    {
        return $this->getCacheCollectionPrefix() . $suffix;
    }

    /**
     * Get cache collection prefix
     *
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return get_called_class();
    }

    /**
     * Get cache minutes
     *
     * @return integer
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }

    /**
     * Set cache minutes
     *
     * @return integer
     */
    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;

        return $this;
    }
}
