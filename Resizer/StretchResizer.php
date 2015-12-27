<?php

namespace Xaben\MediaBundle\Resizer;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class StretchResizer implements ResizerInterface
{
    /**
     * @inheritdoc
     */
    public function resize($binaryData, array $settings)
    {
        $imagine = new Imagine();
        $image = $imagine->load($binaryData);
        $image->resize(new Box($settings['width'], $settings['height']));

        return $image->get('png');
    }
}
