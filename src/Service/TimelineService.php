<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Service;

use Damecode\TimelineBundle\Entity\Timeline;
use Damecode\TimelineBundle\Entity\TimelineItem;
use Damecode\TimelineBundle\Repository\TimelineItemRepository;
use Damecode\TimelineBundle\Repository\TimelineRepository;

final readonly class TimelineService
{
    public function __construct(
        private TimelineItemRepository $timelineItemRepository,
        private TimelineRepository     $timelineRepository
    ) {
    }

    public function create(TimelineItem $timelineItem): void
    {
        $timelineItem->setCreatedAt(new \DateTimeImmutable());
        $this->timelineItemRepository->save($timelineItem);
    }

    /** @param class-string $entityClass */
    public function getTimeline(string $entityClass, int $entityId): Timeline
    {
        $timeline = $this->timelineRepository->findByEntity($entityClass, $entityId);

        if (!$timeline) {
            $timeline = new Timeline();
            $timeline->setEntityClass($entityClass);
            $timeline->setEntityId($entityId);
            $this->timelineRepository->save($timeline);
        }

        return $timeline;
    }
}
