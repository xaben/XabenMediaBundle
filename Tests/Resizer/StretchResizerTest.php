<?php

namespace Xaben\MediaBundle\Tests\Resizer;

use Imagine\Image\Box;
use Xaben\MediaBundle\Resizer\StretchResizer;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class StretchResizerTest extends BaseResizerTest
{
    /**
     * @dataProvider getData
     * @param $settings
     * @param $originalSize
     * @param $expectedSize
     */
    public function testInsetResizer($settings, $originalSize, $expectedSize)
    {
        $resizer = new StretchResizer();
        $resizedBinaryData = $resizer->resize($this->getTestImage($originalSize), $settings);
        $this->checkImageOfExepectedSize($resizedBinaryData, $expectedSize);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            array(array('width' => 400, 'height' => 400, 'upscale' => false), new Box(351, 450), new Box(400,400) ),
            array(array('width' => 400, 'height' => 400, 'upscale' => true), new Box(351, 450), new Box(400,400) ),
        );
    }
}
