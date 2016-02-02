<?php

namespace Xaben\MediaBundle\Locator;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Route;
use Xaben\MediaBundle\Model\Media;

interface MediaLocatorInterface
{
    /**
     * @param Media|array $media
     * @return string
     */
    public function getReferencePath($media);

    /**
     * @param Media|array $media
     * @param string $format
     * @return string
     */
    public function getThumbnailPath($media, $format);

    /**
     * @return Route
     */
    public function getReferenceRoute();

    /**
     * @return Route
     */
    public function getThumbnailRoute();

    /**
     * @param File $file
     * @return string
     */
    public function generateReferenceName(File $file);
}
