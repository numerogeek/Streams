<?php namespace Streams\Generator;

use Illuminate\Filesystem\Filesystem as File;
//use Lex\Parser;

abstract class GeneratorAbstract {

    /**
     * File path to generate
     *
     * @var string
     */
    public $path;

    /**
     * File system instance
     * @var File
     */
    protected $file;

    /**
     * Cache
     * @var Cache
     */
    protected $templateFilename;

    /**
     * Constructor
     *
     * @param $file
     */
    public function __construct()
    {
        $this->file = new File;
    }

    /**
     * Compile template and generate
     *
     * @param  string $path
     * @param  string $template Path to template
     * @return boolean
     */
    public function make($path, $data, $update = false)
    {
        $this->path = $this->getPath($path);

        $template = $this->getTemplate($data);

        if (! $this->file->exists($this->path) or $update)
        {
            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * Get the path to the file
     * that should be generated
     *
     * @param  string $path
     * @return string
     */
    protected function getPath($path)
    {
        // By default, we won't do anything, but
        // it can be overridden from a child class
        return $path;
    }

    /**
     * Get compiled template
     *
     * @param  string $template
     * @param  $name Name of file
     * @return string
     */
    abstract protected function getTemplate($data);
}