<?php

namespace Hackzilla\Bundle\TicketBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Hackzilla\TicketMessage\Model\TicketInterface;
use Hackzilla\TicketMessage\Model\TicketMessageInterface;

class UserLoad
{
    protected $userClass;

    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }

    public function getSubscribedEvents()
    {
        return [
            'postLoad',
        ];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // Ignore any entity lifecycle events not relating to this bundles entities.
        if (!$entity instanceof TicketInterface && !$entity instanceof TicketMessageInterface) {
            return;
        }

        $userRepository = $args->getEntityManager()->getRepository($this->userClass);

        if ($entity instanceof TicketInterface) {
            if (\is_null($entity->getUserCreatedObject())) {
                $entity->setUserCreated($userRepository->find($entity->getUserCreated()));
            }
            if (\is_null($entity->getLastUserObject())) {
                $entity->setLastUser($userRepository->find($entity->getLastUser()));
            }
        } elseif ($entity instanceof TicketMessageInterface) {
            if (\is_null($entity->getUserObject())) {
                $entity->setUser($userRepository->find($entity->getUser()));
            }
        }
    }
}
