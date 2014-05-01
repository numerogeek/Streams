<?php namespace Addon\Module\Addons\Collection;

use Streams\Collection\EntryCollection;

abstract class AddonEntryCollectionAbstract extends EntryCollection
{
    /**
     * Find an item by it's slug attribute.
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