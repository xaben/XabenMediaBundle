<?php

namespace Xaben\MediaBundle\Manager;

use Xaben\MediaBundle\Filesystem\FilesystemInterface;
use Xaben\MediaBundle\Locator\MediaLocatorInterface;
use Xaben\MediaBundle\Model\Media;
use Xaben\MediaBundle\Resizer\ResizerInterface;

class ThumbnailManager
{
    /**
     * @var array
     */
    private $contextConfiguration;

    /**
     * @var array
     */
    private $resizerPool;

    /**
     * @var MediaLocatorInterface
     */
    private $locator;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param array $contextConfiguration
     * @param MediaLocatorInterface $locator
     * @param FilesystemInterface $filesystem
     */
    public function __construct(array $contextConfiguration, MediaLocatorInterface $locator, FilesystemInterface $filesystem)
    {
        $this->contextConfiguration = $contextConfiguration;
        $this->resizerPool = array();
        $this->locator = $locator;
        $this->filesystem = $filesystem;
    }

    /**
     * @param $alias
     * @param ResizerInterface $resizer
     */
    public function addResizer(ResizerInterface $resizer, $alias)
    {
        $this->resizerPool[$alias] = $resizer;
    }

    /**
     * @param Media $media
     * @throws \Exception
     */
    public function generateThumbnails(Media $media)
    {
        $context = $media->getContext();

        if (!array_key_exists($context, $this->contextConfiguration)) {
            throw new \Exception('Supplied context does not exist');
        }

        $formats = $this->contextConfiguration[$context]['formats'];

        $referencePath = $this->locator->getReferencePath($media);

        $referenceBinaryData = $this->filesystem->read($referencePath);

        foreach ($formats as $name => $settings) {
            $path = $this->locator->getThumbnailPath($media, $name);
            $data = $this->generateThumbnail($referenceBinaryData, $settings);
            $this->filesystem->writeContent($path, $data);
        }
    }

    /**
     * @param $binaryData
     * @param $format
     * @return string
     * @throws \Exception
     */
    public function generateThumbnail($binaryData, $format)
    {
        $resizerName = $format['resizer'];

        if (!array_key_exists($resizerName, $this->resizerPool)) {
            throw new \Exception(sprintf('Resizer with name: %s does not exist. Possible resizer names are: %s', $resizerName, json_encode(array_keys($this->resizerPool))));
        }

        /** @var ResizerInterface $resizer */
        $resizer = $this->resizerPool[$resizerName];

        return $resizer->resize($binaryData, $format);
    }
}
