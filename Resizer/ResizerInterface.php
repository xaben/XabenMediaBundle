<?php

namespace Xaben\MediaBundle\Resizer;

interface ResizerInterface
{
    /**
     * @param string $binaryData
     * @param array $settings
     * @return string
     */
    public function resize($binaryData, array $settings);
}
