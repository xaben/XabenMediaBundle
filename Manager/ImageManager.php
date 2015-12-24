<?php

namespace Xaben\MediaBundle\Manager;

use Xaben\MediaBundle\Entity\Media;
use Xaben\MediaBundle\Filesystem\FilesystemInterface;
use Xaben\MediaBundle\Locator\MediaLocatorInterface;

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
     * @var MediaLocatorInterface
     */
    private $locator;

    /**
     * @param FilesystemInterface $filesystem
     * @param MediaLocatorInterface $locator
     */
    public function __construct(FilesystemInterface $filesystem, MediaLocatorInterface $locator)
    {
        $this->filesystem = $filesystem;
        $this->locator = $locator;
    }

    /**
     * @param Media $media
     * @throws \Exception
     */
    public function prepare(Media $media)
    {
        if ($media->getReference()) {
            $media->setOldReferencePath($this->locator->getReferencePath($media));
        }

        if ($media->hasNewFile() || $media->hasReplacedFile()) {
            $media->setReference($this->locator->generateReferenceName($media->getFile()));
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
     */
    private function saveReference(Media $media)
    {
        $file = $media->getFile();
        $path = $this->locator->getReferencePath($media);

        $this->filesystem->write($path, $file);
    }

    /**
     * @param $media
     */
    private function removeOldReference(Media $media)
    {
        $path = $media->getOldReferencePath();
        if ($this->filesystem->has($path)) {
            $this->filesystem->delete($path);
        }
    }
}
