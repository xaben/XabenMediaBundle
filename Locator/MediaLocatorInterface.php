<?php

namespace Xaben\MediaBundle\Locator;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Route;
use Xaben\MediaBundle\Model\Media;

interface MediaLocatorInterface
{
    /**
     * @param Media $media
     * @return string
     */
    public function getReferencePath(Media $media);

    /**
     * @param Media $media
     * @param string $format
     * @return string
     */
    public function getThumbnailPath(Media $media, $format);

    /**
     * @param Media $media
     * @return Route
     */
    public function getReferenceRoute(Media $media);

    /**
     * @param Media $media
     * @return Route
     */
    public function getThumbnailRoute(Media $media);

    /**
     * @param File $file
     * @return string
     */
    public function generateReferenceName(File $file);
}
