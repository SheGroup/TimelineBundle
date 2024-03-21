<?php

declare(strict_types=1);

namespace Damecode\TimelineBundle\EventListener;

use Damecode\TimelineBundle\Entity\TimelineItem;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: TimelineItem::class)]
final readonly class TimelineItemCreatedByEventListener
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {

    }

    public function prePersist(TimelineItem $timelineItem, PrePersistEventArgs $eventArgs): void
    {
        $username = $this->getUsername();
        if ($username) {
            $timelineItem->setCreatedBy($username);
        }
    }

    private function getUsername(): ?string
    {
        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();

            if (method_exists($user, 'getUserIdentifier')) {
                return (string) $user->getUserIdentifier();
            }
            if (method_exists($user, 'getUsername')) {
                return (string) $user->getUsername();
            }
            if (method_exists($user, '__toString')) {
                return $user->__toString();
            }
        }

        return null;
    }
}
