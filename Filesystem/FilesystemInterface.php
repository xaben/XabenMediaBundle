<?php

namespace Xaben\MediaBundle\Filesystem;

use SplFileObject;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
interface FilesystemInterface
{
    /**
     * @param $path
     * @param SplFileObject $file
     * @return mixed
     */
    public function write($path, SplFileObject $file);

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
