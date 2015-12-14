<?php

namespace Xaben\MediaBundle\Filesystem\Adapter;

use Gaufrette\Filesystem;
use SplFileInfo;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class GaufretteAdapter implements FilesystemInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritdoc
     */
    public function write($path, SplFileInfo $file)
    {
        $content = file_get_contents($file->getRealPath());

        return $this->filesystem->write($path, $content);
    }

    /**
     * @inheritdoc
     */
    public function has($path)
    {
        return $this->filesystem->has($path);
    }

    /**
     * @inheritdoc
     */
    public function delete($path)
    {
        return $this->filesystem->delete($path);
    }
}
