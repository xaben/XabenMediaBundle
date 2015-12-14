<?php

namespace Xaben\MediaBundle\Filesystem\Adapter;

use SplFileObject;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class DefaultAdapter implements FilesystemInterface
{

    public function __construct()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @inheritdoc
     */
    public function write($path, SplFileObject $file)
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
