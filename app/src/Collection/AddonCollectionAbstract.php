<?php namespace Streams\Collection;

use Illuminate\Support\Collection;

abstract class AddonCollectionAbstract extends Collection
{
    /**
     * Find an addon by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug) {
        foreach ($this->items as $item) {
            if ($item->slug === $slug) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only installed addons.
     *
     * @return Collection
     */
    public function installed()
    {
        $installed = array();

        foreach ($this->items as $item) {
            if ($item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return only enabled addons.
     *
     * @return Collection
     */
    public function enabled()
    {
        $enabled = array();

        foreach ($this->items as $item) {
            if ($item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Return only active plugins.
     *
     * @return mixed
     */
    public function active()
    {
        return $this->installed()->enabled();
    }
}
