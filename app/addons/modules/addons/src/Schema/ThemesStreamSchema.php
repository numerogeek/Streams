<?php namespace Addon\Module\Addons\Schema;

use Streams\Schema\StreamSchema;

class ThemesStreamSchema extends StreamSchema
{
    /**
     * Stream slug
     *
     * @var string
     */
    public $slug = 'themes';

    /**
     * Return stream assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return array(
            'slug' => array(
                'is_required' => true
            ),
            'is_installed' => array(
                'is_required' => true
            ),
            'is_enabled' => array(
                'is_required' => true
            ),
        );
    }
}