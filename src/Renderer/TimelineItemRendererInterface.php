<?php

namespace Damecode\TimelineBundle\Renderer;

use Damecode\TimelineBundle\Entity\TimelineItem;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'timeline_item.renderer')]
interface TimelineItemRendererInterface
{
    public function matches(TimelineItem $timelineItem): bool;
    public function render(TimelineItem $timelineItem): string;
}