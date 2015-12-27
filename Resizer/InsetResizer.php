<?php

namespace Xaben\MediaBundle\Resizer;

use Imagine\Gd\Imagine;
use Imagine\Image\BoxInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class InsetResizer implements ResizerInterface
{
    /**
     * @inheritdoc
     */
    public function resize($binaryData, array $settings)
    {
        if ($settings['width'] === false && $settings['height'] === false) {
            throw new \RuntimeException('Width/Height parameter is missing. Please add at least one parameter.');
        }

        $imagine = new Imagine();
        $image = $imagine->load($binaryData);

        $imageSize = $image->getSize();
        $box = $this->getBox($imageSize, $settings);

        $image->resize($box);

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

        $ratio = min($ratio);

        return $ratio;
    }
}
