<?php

namespace Xaben\MediaBundle\Locator;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Route;
use Xaben\MediaBundle\Model\Media;

class DefaultMediaLocator implements MediaLocatorInterface
{
    const FIRST_PATH_DIVIDER = 100000;
    const SECOND_PATH_DIVIDER = 1000;

    /**
     * @param Media $media
     * @return string
     */
    public function getReferencePath(Media $media)
    {
        return sprintf(
            'uploads/%s/reference/%s/%d_%s',
            $media->getContext(),
            $this->getMediaPathParts($media),
            $media->getId(),
            $media->getReference()
        );
    }

    /**
     * @param Media $media
     * @param string $format
     * @return string
     */
    public function getThumbnailPath(Media $media, $format)
    {
        return sprintf(
            'uploads/%s/thumbs/%s/%s/thumb_%d.png',
            $media->getContext(),
            $format,
            $this->getMediaPathParts($media),
            $media->getId()
        );
    }

    /**
     * @param Media $media
     * @return Route
     */
    public function getReferenceRoute(Media $media)
    {
        $path = '/uploads/reference/{thousand}/{hundred}/{id}_{reference}';
        $defaults = array(
            '_controller' => 'AppBundle:Extra:extra',
        );
        $requirements = array(
            'thousand' => '\d+',
            'hundred' => '\d+',
            'id' => '\d+',
            'reference' => '\w+'
        );

        return new Route($path, $defaults, $requirements);
    }

    /**
     * @param Media $media
     * @return Route
     */
    public function getThumbnailRoute(Media $media)
    {
        $path = '/uploads/{context}/thumbs/{format}/{thousand}/{hundred}/thumb_{id}.png';
        $defaults = array(
            '_controller' => 'AppBundle:Extra:extra',
        );
        $requirements = array(
            'context' => '\w+',
            'thousand' => '\d+',
            'hundred' => '\d+',
            'id' => '\d+'
        );

        return new Route($path, $defaults, $requirements);
    }

    /**
     * @param Media $media
     * @return string
     */
    private function getMediaPathParts(Media $media)
    {
        $path_part1 = (int) ($media->getId() / self::FIRST_PATH_DIVIDER);
        $path_part2 = (int) (($media->getId() - ($path_part1 * self::FIRST_PATH_DIVIDER)) / self::SECOND_PATH_DIVIDER);

        return sprintf('%04s/%02s', $path_part1 + 1, $path_part2 + 1);
    }

    /**
     * @param File $file
     * @return string
     */
    public function generateReferenceName(File $file)
    {
        $name = sha1(uniqid().rand(1,9999));
        $extension = $file->guessExtension();

        return sprintf('%s.%s', $name, $extension);
    }
}
