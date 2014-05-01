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
}
