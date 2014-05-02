<?php namespace Addon\Module\Addons\Repository;

use Addon\Module\Addons\Contract\AddonRepositoryInterface;
use Streams\Collection\ModuleCollection;

abstract class StreamsAddonRepositoryAbstract implements AddonRepositoryInterface
{
    /**
     * Runtime cache.
     *
     * @var array
     */
    protected $cache = array();

    /**
     * Sync addons with their records in the database.
     *
     * @param ModuleCollection $addons
     */
    public function sync()
    {
        $existingAddons = $this->manager->getAll();
        $databaseAddons = $this->all();

        // Sync TO the database
        foreach ($existingAddons as $addon) {
            if (!$databaseAddons->findBySlug($addon->slug)) {
                $this->addons->insert(
                    array(
                        'slug' => $addon->slug,
                    )
                );
            }
        }
    }

    /**
     * Return all the addons.
     *
     * @return mixed
     */
    public function all()
    {
        if (isset($this->cache['all'])) {
            return $this->cache['all'];
        } else {
            return $this->cache['all'] = $this->addons->all();
        }
    }
}