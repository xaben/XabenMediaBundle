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
        $media->setFile(new MediaFile($media));

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
            $this->removeReference($media);
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
        $this->removeReference($media);
    }

    /**
     * @param $media
     * @throws \Exception
     * //TODO: WIP
     */
    private function saveReference($media)
    {
        $mediaFile = $this->getMediaFile($media);
        $uploadedFile = $mediaFile->getUploadedFile();

        $this->filesystem->write('test.txt', $uploadedFile);
    }

    /**
     * @param $media
     * //TODO:WIP
     */
    private function removeReference($media)
    {
        $this->filesystem->delete('test.txt');
    }
}
