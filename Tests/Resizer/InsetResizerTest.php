<?php

namespace Xaben\MediaBundle\Tests\Resizer;

use Imagine\Image\Box;
use Xaben\MediaBundle\Resizer\InsetResizer;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class InsetResizerTest extends BaseResizerTest
{
    /**
     * @dataProvider getData
     */
    public function testInsetResizer($settings, $originalSize, $expectedSize)
    {
        $resizer = new InsetResizer();
        $resizedBinaryData = $resizer->resize($this->getTestImage($originalSize), $settings);
        $this->checkImageOfExepectedSize($resizedBinaryData, $expectedSize);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            array(array('width' => 400, 'height' => 400, 'upscale' => false), new Box(400, 400), new Box(400,400) ),
            array(array('width' => 200, 'height' => 200, 'upscale' => false), new Box(400, 400), new Box(200,200) ),
            array(array('width' => 90, 'height' => false, 'upscale' => false), new Box(567, 200), new Box(90,32) ),
            array(array('width' => false, 'height' => 31, 'upscale' => false), new Box(567, 200), new Box(88,31) ),
            array(array('width' => 400, 'height' => 400, 'upscale' => true), new Box(100, 100), new Box(400,400) ),
        );
    }
}
