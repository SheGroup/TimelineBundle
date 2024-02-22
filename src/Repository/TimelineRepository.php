<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Repository;

use Damecode\TimelineBundle\Entity\Timeline;

interface TimelineRepository
{
    /** @param class-string $entityClass */
    public function findByEntity(string $entityClass, int $entityId): ?Timeline;

    /** @param iterable<int, Timeline> $timelines */
    public function saveAll(iterable $timelines): void;
    public function save(Timeline $timeline): void;
    public function remove(Timeline $timeline): void;
}
