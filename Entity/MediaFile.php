<?php

namespace Xaben\MediaBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class MediaFile
{
    /**
     * @var Media
     */
    private $media;

    /**
     * @var string
     */
    private $oldReference;

    /**
     * @var File | null
     */
    private $uploadedFile;

    /**
     * @param Media $media
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
        $this->oldReference = $media->getReference();
        $this->uploadedFile = $media->getFile() instanceof File ? $media->getFile() : null;
    }

    /**
     * @return string
     */
    public function getOldReference()
    {
        return $this->oldReference;
    }

    /**
     * @return File
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }
}
