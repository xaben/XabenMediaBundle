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
     * @param $path
     * @return mixed
     */
    public function read($path);

    /**
     * @param $path
     * @param $content
     * @return mixed
     */
    public function writeContent($path, $content);

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
