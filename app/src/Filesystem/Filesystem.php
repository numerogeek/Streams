<?php namespace Streams\Filesystem;

class Filesystem
{
    /**
     * Get directories (absolute paths)
     *
     * @param string $path
     * @return array
     */
    public function getDirectoryPaths($path = '')
    {
        $directories = array();

        if (is_dir($path)) {

            // This is much faster than glob($path . '/*');
            $iterator = new \DirectoryIterator($path);

            foreach ($iterator as $fileInfo) {
                if (!$fileInfo->isDot() and $fileInfo->isDir()) {
                    $directories[] = $fileInfo->getPathname();
                }
            };
        }

        return $directories;
    }
}
