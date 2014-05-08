<?php namespace Streams\Support;

use Stolz\Assets\Manager;

class Assets extends Manager
{
    /**
     * An array of available paths for assets by their loader's namespace.
     *
     * @var array
     */
    protected $paths = array(
        'js'  => array(),
        'css' => array(),
        'img' => array(),
    );

    /**
     * Add an asset or array of assets.
     *
     * @param mixed $asset
     * @return Manager|void
     */
    public function add($asset)
    {
        if (is_array($asset) and $assets = $asset) {
            foreach ($assets as $asset) {
                $this->add($asset);
            }
        } else {
            $parts     = explode('.', $asset);
            $extension = end($parts);

            if ($extension == 'js') {
                parent::add($this->getRealPath($asset, 'js'));
            } elseif ($extension == 'css') {
                parent::addCss($this->getRealPath($asset, 'css'));
            }
        }
    }

    /**
     * Add a js asset.
     *
     * @param mixed $asset
     * @return void
     */
    public function addJs($asset)
    {
        parent::addJs($this->getRealPath($asset, 'js'));
    }

    /**
     * Add a css asset.
     *
     * @param mixed $asset
     * @return void
     */
    public function addCss($asset)
    {
        parent::addJs($this->getRealPath($asset, 'css'));
    }

    /**
     * Replace the namespace in a path.
     *
     * @param $asset
     * @return string
     */
    protected function getRealPath($asset, $type)
    {
        if (($position = strpos($asset, '::')) !== false) {
            $namespace = substr($asset, 0, $position);
            $path      = $this->getPath($namespace, $type);

            return str_replace($namespace . '::', $path . '/', $asset);
        }

        return $asset;
    }

    /**
     * Add a js asset path.
     *
     * @param $namespace
     * @param $path
     */
    public function addJsPath($namespace, $path)
    {
        $this->addPath($namespace, $path, 'js');
    }

    /**
     * Add a css asset path.
     *
     * @param $namespace
     * @param $path
     */
    public function addCssPath($namespace, $path)
    {
        $this->addPath($namespace, $path, 'css');
    }

    /**
     * Add an img asset path.
     *
     * @param $namespace
     * @param $path
     */
    public function addImgPath($namespace, $path)
    {
        $this->addPath($namespace, $path, 'img');
    }

    /**
     * Add all types of paths for a namespace.
     *
     * @param $namespace
     * @param $path
     */
    public function addPaths($namespace, $path)
    {
        $this->addJsPath($namespace, $path . '/js');
        $this->addCssPath($namespace, $path . '/css');
        $this->addImgPath($namespace, $path . '/img');
    }

    /**
     * Add an asset path.
     *
     * @param $namespace
     * @param $path
     * @param $type
     */
    protected function addPath($namespace, $path, $type)
    {
        $this->paths[$type][$namespace] = $path;
    }

    /**
     * Get a js asset path.
     *
     * @param $namespace
     * @return null
     */
    public function getJsPath($namespace)
    {
        return $this->getPath($namespace, 'js');
    }

    /**
     * Get a css asset path.
     *
     * @param $namespace
     * @return null
     */
    public function getCssPath($namespace)
    {
        return $this->getPath($namespace, 'css');
    }

    /**
     * Get an image asset path.
     *
     * @param $namespace
     * @return null
     */
    public function getImgPath($namespace)
    {
        return $this->getPath($namespace, 'img');
    }

    /**
     * Get a path for a namespace and asset type.
     *
     * @param $namespace
     * @param $type
     * @return null
     */
    protected function getPath($namespace, $type)
    {
        if (isset($this->paths[$type][$namespace])) {
            return $this->paths[$type][$namespace];
        }

        return null;
    }
}
