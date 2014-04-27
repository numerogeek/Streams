<?php namespace Streams\Cache;

use Illuminate\Support\Collection;

class CacheCollection extends Collection
{
    /**
     * Our cache collection key.
     *
     * @var string|string
     */
    protected $collectionKey;

    /**
     * Create a new CacheCollection instance.
     *
     * @param array  $items
     * @param string $key
     */
    public function __construct(array $items, string $key = null)
    {
        $this->collectionKey = $key;
        $this->items         = $items;
    }

    /**
     * Set the collection key.
     *
     * @param null $key
     * @return $this
     */
    public function setKey($key = null)
    {
        $this->collectionKey = $key;

        return $this;
    }

    /**
     * Filter cached items as unique only.
     *
     * @return $this|Collection
     */
    public function unique()
    {
        $this->items = array_unique($this->items);

        $this->values();

        return $this;
    }

    /**
     * Add cache keys.
     *
     * @param array $keys
     * @return $this
     */
    public function addKeys(array $keys = array())
    {
        foreach ($keys as $key) {
            $this->push($key);
        }

        $this->unique();

        return $this;
    }

    /**
     * Index cache keys.
     *
     * @return $this
     */
    public function index()
    {
        if ($keys = ci()->cache->get($this->collectionKey)) {
            $this->addKeys($keys);
        }

        $this->unique();

        ci()->cache->forget($this->collectionKey);

        $self = $this;

        ci()->cache->rememberForever(
            $this->collectionKey,
            function () use ($self) {
                return $self->all();
            }
        );

        return $this;
    }

    /**
     * Flush cache keys.
     *
     * @return $this
     */
    public function flush()
    {
        foreach ($this->items as $key) {
            ci()->cache->forget($key);
        }

        ci()->cache->forget($this->collectionKey);

        $this->items = array();

        return $this;
    }
}
