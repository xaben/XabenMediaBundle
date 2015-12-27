<?php

namespace Xaben\MediaBundle\Resizer;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class OutboundResizer implements ResizerInterface
{
    /**
     * @inheritdoc
     */
    public function resize($binaryData, array $settings)
    {
        if ($settings['width'] === false || $settings['height'] === false) {
            throw new \RuntimeException('Width or Height parameter is missing. Please add both parameters for Outbound resizer.');
        }

        $imagine = new Imagine();
        $image = $imagine->load($binaryData);

        $imageSize = $image->getSize();
        $box = $this->getBox($imageSize, $settings);

        $image->resize($box);

        $image = $this->cropImage($image, $settings);

        return $image->get('png');
    }

    /**
     * @param BoxInterface $imageSize
     * @param array $settings
     * @return BoxInterface
     */
    private function getBox(BoxInterface $imageSize, array $settings)
    {
        $ratio = $this->calculateRatio($imageSize, $settings);

        if ($ratio < 1 || $settings['upscale']) {
            $imageSize = $imageSize->scale($ratio);
        }

        return $imageSize;
    }

    /**
     * @param BoxInterface $imageSize
     * @param array $settings

     * @return array|mixed
     */
    private function calculateRatio(BoxInterface $imageSize, array $settings)
    {
        $ratio = array();
        if ($settings['height']) {
            $ratio[] = $settings['height'] / $imageSize->getHeight();
        }

        if ($settings['width']) {
            $ratio[] = $settings['width'] / $imageSize->getWidth();
        }

        $ratio = max($ratio);

        return $ratio;
    }

    /**
     * Crop image if exceeds boundaries
     *
     * @param ImageInterface $image
     * @param $settings
     * @return ImageInterface
     */
    private function cropImage(ImageInterface $image, $settings)
    {
        $neededSize = new Box($settings['width'], $settings['height']);
        $currentSize = $image->getSize();

        if ($neededSize->contains($currentSize)) {
            return $image;
        }

        $point = new Point(
            $currentSize->getWidth() > $neededSize->getWidth() ? round(($currentSize->getWidth() - $neededSize->getWidth()) / 2) : 0,
            $currentSize->getHeight() > $neededSize->getHeight() ? round(($currentSize->getHeight() - $neededSize->getHeight()) / 2) : 0
        );

        $image->crop($point, $neededSize);

        return $image;
    }
}
