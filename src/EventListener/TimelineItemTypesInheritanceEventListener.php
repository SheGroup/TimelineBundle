<?php

declare(strict_types=1);

namespace Damecode\TimelineBundle\EventListener;

use Damecode\TimelineBundle\Entity\TimelineItem;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\MappingException;
use ReflectionException;

#[AsDoctrineListener(event: Events::loadClassMetadata)]
final class TimelineItemTypesInheritanceEventListener
{
    /** @throws MappingException|ReflectionException */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();
        if (TimelineItem::class !== $classMetadata->getName()) {
            return;
        }

        $classMetadata->discriminatorMap = [];

        foreach (get_declared_classes() as $class) {
            $classReflection = new \ReflectionClass($class);

            if ($classReflection->isSubclassOf(TimelineItem::class)) {
                $classMetadata->addDiscriminatorMapClass($classReflection->getName(), $classReflection->getName());
            }
        }
    }
}
