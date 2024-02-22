<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Repository;

use Damecode\TimelineBundle\Entity\Timeline;
use Damecode\TimelineBundle\Entity\TimelineItem;

interface TimelineItemRepository
{
    /** @param iterable<int, TimelineItem> $timelineItems */
    public function saveAll(iterable $timelineItems): void;

    /** @return iterable<int, TimelineItem> */
    public function findByTimeline(Timeline $timeline): iterable;
    public function save(TimelineItem $timelineItem): void;
    public function remove(TimelineItem $timelineItem): void;
}
