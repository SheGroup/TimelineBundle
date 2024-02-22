<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Repository;

use Damecode\TimelineBundle\Entity\Timeline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Timeline> */
final class DoctrineTimelineRepository extends ServiceEntityRepository implements TimelineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timeline::class);
    }

    public function findByEntity(string $entityClass, int $entityId): ?Timeline
    {
        return $this->findOneBy(['entityClass' => $entityClass, 'entityId' => $entityId]);
    }

    public function saveAll(iterable $timelines): void
    {
        foreach ($timelines as $timeline) {
            $this->getEntityManager()->persist($timeline);
        }
        $this->getEntityManager()->flush();
    }

    public function save(Timeline $timeline): void
    {
        $this->getEntityManager()->persist($timeline);
        $this->getEntityManager()->flush();
    }

    public function remove(Timeline $timeline): void
    {
        $this->getEntityManager()->remove($timeline);
        $this->getEntityManager()->flush();
    }
}
