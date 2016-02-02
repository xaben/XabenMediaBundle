<?php

namespace Xaben\MediaBundle\Twig;

use Twig_SimpleFunction;
use Xaben\MediaBundle\Locator\MediaLocatorInterface;
use Xaben\MediaBundle\Model\Media;

class MediaExtension extends \Twig_Extension
{
    /**
     * @var MediaLocatorInterface
     */
    private $locator;

    /**
     * @param MediaLocatorInterface $locator
     */
    public function __construct(MediaLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('media', array($this, 'media'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('media_path', array($this, 'mediaPath'), array('is_safe' => array('html'))),
        );
    }

    public function media($media, $format, array $options = array())
    {
        $optionsString = implode(
            ' ',
            array_map(
                function ($key, $value) {
                    return $key . '="' . $value . '"';
                },
                array_keys($options),
                $options
            )
        );

        return sprintf(
            '<img src="%s" alt="%s" %s/>',
            $this->mediaPath($media, $format),
            $media instanceof Media ? $media->getTitle() : $media['title'],
            $optionsString
            );
    }

    public function mediaPath($media, $format)
    {
        return $format === 'reference' ?
            $this->locator->getReferencePath($media) :
            $this->locator->getThumbnailPath($media, $format);
    }

    public function getName()
    {
        return 'xaben_media_extension';
    }
}
