<?php

namespace Xaben\MediaBundle\Tests\Locator;

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

    public static function getFixtures()
    {
        return array(
            array(
                'id' => 1,
                'context' => 'mycontext',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/mycontext/reference/0001/01/1_testReference'
            ),
            array(
                'id' => 1999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0001/02/1999_testReference'
            ),
            array(
                'id' => 10999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0001/11/10999_testReference'
            ),
            array(
                'id' => 100999,
                'context' => 'context',
                'format' => 'test',
                'reference' => 'testReference',
                'referencePath' => 'uploads/context/reference/0002/01/100999_testReference'
            )
        );
    }
}
