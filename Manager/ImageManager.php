<?php

namespace Xaben\MediaBundle\Manager;

use Xaben\MediaBundle\Entity\Media;
use Xaben\MediaBundle\Entity\MediaFile;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class ImageManager
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param Media $media
     * @throws \Exception
     */
    public function prepare(Media $media)
    {
        $media->backupReference();

        if ($media->hasNewFile() || $media->hasReplacedFile()) {
            $media->setReference('test.txt');
        }
    }

    /**
     * @param Media $media
     */
    public function process(Media $media)
    {
        if ($media->hasReplacedFile()) {
            $this->removeOldReference($media);
        }

        if ($media->hasReplacedFile() || $media->hasNewFile()) {
            $this->saveReference($media);
        }
    }

    /**
     * @param Media $media
     */
    public function remove(Media $media)
    {
        $this->removeOldReference($media);
    }

    /**
     * @param $media
     * @throws \Exception
     * //TODO: WIP
     */
    private function saveReference(Media $media)
    {
        $file = $media->getFile();
        $reference = $media->getReference();
        $path = 'test.txt'; // get from location service

        $this->filesystem->write('test.txt', $file);
    }

    /**
     * @param $media
     * //TODO:WIP
     */
    private function removeOldReference(Media $media)
    {
        $oldReference = $media->getOldReference();
        $path = 'test.txt'; // get from location service
        $this->filesystem->delete('test.txt');
    }
}
