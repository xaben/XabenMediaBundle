<?php

namespace Xaben\MediaBundle\Tests\Locator;

use Symfony\Component\Routing\Route;
use Xaben\MediaBundle\Locator\DefaultMediaLocator;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class DefaultMediaLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getFixtures
     * @param $id
     * @param $context
     * @param $format
     * @param $reference
     * @param $referencePath
     */
    public function testReturnsCorrectReferencePath($id, $context, $format, $reference, $referencePath)
    {
        $media = $this->getMockBuilder('Xaben\MediaBundle\Model\Media')
            ->setMethods(array('getId', 'getReference', 'getContext'))
            ->getMock();
        $media
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
        $media->expects($this->once())
            ->method('getReference')
            ->will($this->returnValue($reference));
        $media->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($context));

        $locator = new DefaultMediaLocator();

        $this->assertEquals($referencePath, $locator->getReferencePath($media));
    }

    /**
     * @dataProvider getFixtures
     * @param $id
     * @param $context
     * @param $format
     * @param $reference
     * @param $referencePath
     * @param $thumbnailPath
     */
    public function testReturnsCorrectThumbnailPath($id, $context, $format, $reference, $referencePath, $thumbnailPath)
    {
        $media = $this->getMockBuilder('Xaben\MediaBundle\Model\Media')
            ->setMethods(array('getId', 'getReference', 'getContext'))
            ->getMock();
        $media
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
        $media->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($context));

        $locator = new DefaultMediaLocator();

        $this->assertEquals($thumbnailPath, $locator->getThumbnailPath($media, $format));
    }

    public function testReturnsRouteObject()
    {
        $locator = new DefaultMediaLocator();
        $this->assertTrue($locator->getReferenceRoute() instanceof Route);
        $this->assertTrue($locator->getThumbnailRoute() instanceof Route);
    }


    public static function getFixtures()
    {
        return array(
            array(
                'id' => 1,
                'context' => 'mycontext',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/mycontext/reference/0001/01/1_testReference',
                'thumbnailPath' => 'uploads/mycontext/thumbs/test/0001/01/thumb_1.png',
            ),
            array(
                'id' => 1999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0001/02/1999_testReference',
                'thumbnailPath' => 'uploads/context/thumbs/test/0001/02/thumb_1999.png',
            ),
            array(
                'id' => 10999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0001/11/10999_testReference',
                'thumbnailPath' => 'uploads/context/thumbs/test/0001/11/thumb_10999.png',
            ),
            array(
                'id' => 100999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0002/01/100999_testReference',
                'thumbnailPath' => 'uploads/context/thumbs/test/0002/01/thumb_100999.png',
            )
        );
    }
}
