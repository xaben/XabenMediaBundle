<?php

namespace Xaben\MediaBundle\Filesystem\Adapter;

use SplFileInfo;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class DefaultAdapter implements FilesystemInterface
{

    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function write($path, SplFileInfo $file)
    {
    }

    /**
     * @inheritdoc
     */
    public function has($path)
    {
    }

    /**
     * @inheritdoc
     */
    public function delete($path)
    {
    }
}
