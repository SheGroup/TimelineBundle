<?php

namespace Damecode\TimelineBundle\Service;

use Damecode\TimelineBundle\Entity\TimelineItem;
use Damecode\TimelineBundle\Renderer\TimelineItemRendererInterface;
use Damecode\TimelineBundle\RendererNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class TimelineItemRenderer
{
    /** @var iterable<int, TimelineItemRendererInterface> $renderers */
    private iterable $renderers;

    /** @param iterable<int, TimelineItemRendererInterface> $renderers */
    public function __construct(#[TaggedIterator(tag: 'timeline_item.renderer')]iterable $renderers)
    {
        $this->renderers = $renderers;
    }

    /**
     * @throws RendererNotFoundException
     */
    public function render(TimelineItem $timelineItem): string
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->matches($timelineItem)) {
                return $renderer->render($timelineItem);
            }
        }

        throw new RendererNotFoundException(sprintf('Renderer not found for TimelineItem of class %s', $timelineItem::class));
    }
}
