<?php

namespace Xaben\MediaBundle\Tests\Resizer;

use Imagine\Image\Box;
use Xaben\MediaBundle\Resizer\OutboundResizer;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class OutboundResizerTest extends BaseResizerTest
{
    /**
     * @dataProvider getData
     * @param $settings
     * @param $originalSize
     * @param $expectedSize
     */
    public function testInsetResizer($settings, $originalSize, $expectedSize)
    {
        $resizer = new OutboundResizer();
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
            array(array('width' => 199, 'height' => 99, 'upscale' => false), new Box(853, 99), new Box(199,99) ),
            array(array('width' => 400, 'height' => 400, 'upscale' => true), new Box(100, 100), new Box(400,400) ),
            array(array('width' => 300, 'height' => 100, 'upscale' => true), new Box(100, 50), new Box(300,100) ),
        );
    }
}
