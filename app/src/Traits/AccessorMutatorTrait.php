<?php namespace Streams\Traits;

trait AccessorMutatorTrait
{
    /**
     * Set a property value.
     *
     * @param $property
     * @param $value
     * @return $this
     */
    public function set($property, $value)
    {
        $this->{$property} = $value;

        return $this;
    }

    /**
     * Get a property value.
     *
     * @param $property
     * @param $default
     * @return mixed
     */
    public function get($property, $default)
    {
        return isset($this->{$property}) ? $this->{$property} : $default;
    }
}