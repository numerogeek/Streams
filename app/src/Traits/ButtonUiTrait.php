<?php namespace Streams\Traits;

trait ButtonUiTrait
{
    /**
     * Get buttons for a given row.
     *
     * @param $buttons
     * @param $entry
     * @return string
     */
    protected function getRowButtons($entry)
    {
        // Are our buttons closure as a whole?
        if (is_callable($this->buttons)) {
            return call_user_func($this->buttons, $entry);

            // If it's a string - parse the entire thing.
        } elseif (is_string($this->buttons)) {
            return $this->buttons;

            // If it is an array of options - process them.
        } elseif (is_array($this->buttons)) {

            $return = array();

            foreach ($this->buttons as $button) {
                $button = array(
                    'url'        => $this->getRowButtonUrl($button, $entry),
                    'title'      => $this->getRowButtonTitle($button, $entry),
                    'attributes' => $this->getRowButtonAttributes($button, $entry),
                );

                $return[] = \HTML::link($button['url'], $button['title'], (array)$button['attributes']);
            }

            return implode('', $return);
        }
    }

    /**
     * Get the button url for this row.
     *
     * @param $button
     * @param $entry
     * @return mixed|null|string
     */
    protected function getRowButtonUrl($button, $entry)
    {
        if (isset($button['url'])) {

            // Is the link a closure?
            if (is_callable($button['url'])) {
                return call_user_func($button['url'], $entry);
            }

            return $button['url'];
        }

        return null;
    }

    /**
     * Get the button title for this row.
     *
     * @param $button
     * @param $entry
     * @return mixed|null|string
     */
    protected function getRowButtonTitle($button, $entry)
    {
        if (isset($button['title'])) {

            // Is the title a closure?
            if (is_callable($button['title'])) {
                return call_user_func($button['title'], $entry);
            }

            return $button['title'];
        }

        return null;
    }

    /**
     * Get the button attributes for this row.
     *
     * @param $button
     * @param $entry
     * @return mixed|null|string
     */
    protected function getRowButtonAttributes($button, $entry)
    {
        if (isset($button['attributes'])) {

            // Are the attributes a closure?
            if (is_callable($button['attributes'])) {
                return call_user_func($button['attributes'], $entry);

                // If they are a string - parse the entire thing.
            } elseif (is_string($button['attributes'])) {
                return $button['attributes'];

                // If it is an array of attributes - process and return them.
            } elseif (is_array($button['attributes'])) {
                return $this->processButtonAttributes($button['attributes'], $entry);
            }
        }

        return null;
    }

    /**
     * Process button attributes.
     *
     * @param $attributes
     * @param $entry
     * @return array
     */
    protected function processButtonAttributes($attributes, $entry)
    {
        $return = array();

        foreach ($attributes as $attribute => $value) {

            // Is the attribute a closure?
            if (is_callable($value)) {
                $return[] = call_user_func($value, $entry);

                // If it's a string - parse the entire thing.
            } elseif (is_string($value)) {
                $return[$attribute] = $value;
            }
        }

        return $return;
    }
}
