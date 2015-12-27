<?php

namespace Xaben\MediaBundle\Filesystem\Adapter;

use League\Flysystem\FilesystemInterface as FlysystemFileInterface;
use SplFileInfo;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class FlysystemAdapter implements FilesystemInterface
{
    /**
     * @var FlysystemFileInterface
     */
    private $filesystem;

    /**
     * @param FlysystemFileInterface $filesystem
     */
    public function __construct(FlysystemFileInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritdoc
     */
    public function write($path, SplFileInfo $file)
    {
        $stream = fopen($file->getRealPath(), 'r+');
        $result = $this->filesystem->putStream($path, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return $result;
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

    /**
     * @param $path
     * @return mixed
     */
    public function read($path)
    {
        return $this->filesystem->read($path);
    }

    /**
     * @param $path
     * @param $content
     * @return mixed
     */
    public function writeContent($path, $content)
    {
        $result = $this->filesystem->write($path, $content);

        return $result;
    }
}
