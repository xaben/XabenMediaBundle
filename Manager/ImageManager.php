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
     * @var ThumbnailManager
     */
    private $thumbnailManager;

    /**
     * @param FilesystemInterface $filesystem
     * @param MediaLocatorInterface $locator
     * @param ThumbnailManager $thumbnailManager
     */
    public function __construct(FilesystemInterface $filesystem, MediaLocatorInterface $locator, ThumbnailManager $thumbnailManager)
    {
        $this->filesystem = $filesystem;
        $this->locator = $locator;
        $this->thumbnailManager = $thumbnailManager;
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
            $this->generateThumbs($media);
        }
    }

    /**
     * @param Media $media
     */
    public function remove(Media $media)
    {
        $this->removeOldReference($media);
        $this->removeThumbs($media);
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

    /**
     * @param Media $media
     */
    private function generateThumbs(Media $media)
    {
        $this->thumbnailManager->generateThumbnails($media);
    }

    /**
     * @param Media $media
     */
    private function removeThumbs(Media $media)
    {
        //TODO: implement
    }
}
