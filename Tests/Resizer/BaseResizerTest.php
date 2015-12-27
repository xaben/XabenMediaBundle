<?php

namespace Xaben\MediaBundle\Tests\Resizer;

use Imagine\Image\BoxInterface;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
abstract class BaseResizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $binaryData
     * @param BoxInterface $expectedSize
     */
    protected function checkImageOfExepectedSize($binaryData, BoxInterface $expectedSize)
    {
        $image = imagecreatefromstring($binaryData);
        $this->assertEquals($expectedSize->getWidth(), imagesx($image));
        $this->assertEquals($expectedSize->getHeight(), imagesy($image));
    }

    /**
     * @param BoxInterface $originalSize
     * @return string
     */
    protected function getTestImage(BoxInterface $originalSize)
    {
        ob_start();
        imagejpeg(imagecreatetruecolor($originalSize->getWidth(), $originalSize->getHeight()));

        return ob_get_clean();
    }
}
