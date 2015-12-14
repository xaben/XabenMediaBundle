<?php

namespace Xaben\MediaBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Media
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $oldReference;

    /**
     * @var string
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $context;

    /**
     * @var UploadedFile
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
    public function getOldReference()
    {
        return $this->oldReference;
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
        return $this->getFile() instanceof UploadedFile && $this->getOldReference() === null;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasReplacedFile()
    {
        return $this->getFile() instanceof UploadedFile && $this->getOldReference() !== null;
    }

    /**
     * Backup old reference for further removal
     */
    public function backupReference()
    {
        $this->oldReference = $this->getReference();
    }
}
