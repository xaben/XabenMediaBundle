<?php

namespace Xaben\MediaBundle\Locator;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Route;
use Xaben\MediaBundle\Exception\XabenMediaException;
use Xaben\MediaBundle\Model\Media;

class DefaultMediaLocator implements MediaLocatorInterface
{
    const FIRST_PATH_DIVIDER = 100000;
    const SECOND_PATH_DIVIDER = 1000;

    /**
     * @param Media|array $media
     * @return string
     */
    public function getReferencePath($media)
    {
        $media = $this->normalizeMedia($media);

        return sprintf(
            'uploads/%s/reference/%s/%d_%s',
            $media['context'],
            $this->getMediaPathParts($media),
            $media['id'],
            $media['reference']
        );
    }

    /**
     * @param Media|array $media
     * @param string $format
     * @return string
     */
    public function getThumbnailPath($media, $format)
    {
        $media = $this->normalizeMedia($media);

        return sprintf(
            'uploads/%s/thumbs/%s/%s/thumb_%d.png',
            $media['context'],
            $format,
            $this->getMediaPathParts($media),
            $media['id']
        );
    }

    /**
     * @return Route
     */
    public function getReferenceRoute()
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
     * @return Route
     */
    public function getThumbnailRoute()
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
     * @param array $media
     * @return string
     */
    private function getMediaPathParts(array $media)
    {
        $path_part1 = (int)($media['id'] / self::FIRST_PATH_DIVIDER);
        $path_part2 = (int)(($media['id'] - ($path_part1 * self::FIRST_PATH_DIVIDER)) / self::SECOND_PATH_DIVIDER);

        return sprintf('%04s/%02s', $path_part1 + 1, $path_part2 + 1);
    }

    /**
     * @param File $file
     * @return string
     */
    public function generateReferenceName(File $file)
    {
        $name = sha1(uniqid() . rand(1, 9999));
        $extension = $file->guessExtension();

        return sprintf('%s.%s', $name, $extension);
    }

    /**
     * Check if media array contains all required keys
     *
     * @param $media
     * @throws XabenMediaException
     */
    private function validateMedia($media)
    {
        $requiredKeys = array(
            'id',
            'context',
            'reference',
        );

        if (count(array_intersect_key(array_flip($requiredKeys), $media)) !== count($requiredKeys)) {
            throw new XabenMediaException('Provided media object / array does not contain all required fields.');
        }
    }

    /**
     * @param $media
     * @return array
     * @throws XabenMediaException
     */
    private function normalizeMedia($media)
    {
        if ($media instanceof Media) {
            $media = array(
                'id' => $media->getId(),
                'context' => $media->getContext(),
                'reference' => $media->getReference(),
            );
        } else {
            $this->validateMedia($media);
        }

        return $media;
    }
}
