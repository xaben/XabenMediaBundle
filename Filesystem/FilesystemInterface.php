<?php

namespace Xaben\MediaBundle\Filesystem;

use SplFileInfo;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
interface FilesystemInterface
{
    /**
     * @param $path
     * @param SplFileInfo $file
     * @return mixed
     */
    public function write($path, SplFileInfo $file);

    /**
     * Check if file exists
     *
     * @param $path
     * @return bool
     */
    public function has($path);

    /**
     * Remove file
     *
     * @param $path
     * @return bool
     */
    public function delete($path);
}
