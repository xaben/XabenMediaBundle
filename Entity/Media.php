<?php

namespace Xaben\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="media__media")
 * @ORM\Entity()
 *
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class Media
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string")
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="reference", type="string")
     *
     * @var string
     */
    protected $reference;

    /**
     * @ORM\Column(name="metadata", type="text", nullable=true)
     *
     * @var string
     */
    protected $metadata;

    /**
     * @ORM\Column(name="context", type="string")
     *
     * @var string
     */
    protected $context;

    /**
     * @var UploadedFile | MediaFile | null
     */
    protected $file;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasNewFile()
    {
        $mediaFile = $this->getMediaFile();

        return $mediaFile->getUploadedFile() instanceof UploadedFile && $mediaFile->getOldReference() === null;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasReplacedFile()
    {
        $mediaFile = $this->getMediaFile();

        return $mediaFile->getUploadedFile() instanceof UploadedFile && $mediaFile->getOldReference() !== null;
    }

    /**
     * @return MediaFile
     * @throws \Exception
     */
    private function getMediaFile()
    {
        $mediaFile = $this->getFile();

        if (!$mediaFile instanceof MediaFile) {
            throw new \Exception('Expected a MediaFile, got:' . get_class($mediaFile));
        }
        return $mediaFile;
    }
}
