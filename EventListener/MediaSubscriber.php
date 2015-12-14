<?php

namespace Xaben\MediaBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Xaben\MediaBundle\Entity\Media;
use Doctrine\Common\EventSubscriber;
use Xaben\MediaBundle\Manager\ImageManager;

/**
 * @author Alexandru Benzari <benzari.alex@gmail.com>
 */
class MediaSubscriber implements EventSubscriber
{
    /**
     * @var ImageManager
     */
    private $manager;

    /**
     * @param ImageManager $manager
     */
    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'preRemove',
            'postPersist',
            'postUpdate',
            'postRemove',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->prepareMedia($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->prepareMedia($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $this->prepareMedia($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->processMedia($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->processMedia($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->removeMedia($args);
    }

    private function prepareMedia(LifecycleEventArgs $args)
    {
        /** @var Media $media */
        $media = $args->getEntity();
        if (!$media instanceof Media) {
            return;
        }

        $this->manager->prepare($media);
    }

    private function processMedia(LifecycleEventArgs $args)
    {
        /** @var Media $media */
        $media = $args->getEntity();
        if (!$media instanceof Media) {
            return;
        }

        $this->manager->process($media);
    }

    private function removeMedia(LifecycleEventArgs $args)
    {
        /** @var Media $media */
        $media = $args->getEntity();
        if ($media instanceof Media) {
            return;
        }

        $this->manager->remove($media);
    }
}
