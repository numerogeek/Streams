<?php namespace Addon\Module\Addons\Repository;

use Addon\Module\Addons\Contract\AddonRepositoryInterface;
use Streams\Collection\ModuleCollection;

abstract class StreamsAddonRepositoryAbstract implements AddonRepositoryInterface
{
    /**
     * Sync addons with their records in the database.
     *
     * @param ModuleCollection $addons
     */
    public function sync()
    {
        $existingAddons = $this->manager->getAll();
        $databaseAddons = $this->addons->all();

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
        return $this->addons->all();
    }
}