<?php namespace Addon\Module\Addons\Traits;

trait SyncTrait
{
    /**
     * Syn addons from file system to database and back.
     */
    public function sync()
    {
        $class   = explode('\\', get_called_class());
        $manager = \Str::studly(str_replace('EntryModel', null, end($class)));

        $existingAddons = $manager::getAll();
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
}