<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Repository;

use Damecode\TimelineBundle\Entity\Timeline;
use Damecode\TimelineBundle\Entity\TimelineItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<TimelineItem> */
final class DoctrineTimelineItemRepository extends ServiceEntityRepository implements TimelineItemRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimelineItem::class);
    }

    public function saveAll(iterable $timelineItems): void
    {
        foreach ($timelineItems as $timelineItem) {
            $this->getEntityManager()->persist($timelineItem);
        }
        $this->getEntityManager()->flush();
    }

    public function save(TimelineItem $timelineItem): void
    {
        $this->getEntityManager()->persist($timelineItem);
        $this->getEntityManager()->flush();
    }

    public function remove(TimelineItem $timelineItem): void
    {
        $this->getEntityManager()->remove($timelineItem);
        $this->getEntityManager()->flush();
    }

    public function findByTimeline(Timeline $timeline): iterable
    {
        return $this->findBy(['timelines' => [$timeline]]);
    }
}
