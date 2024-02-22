<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Entity;

use Damecode\TimelineBundle\Repository\DoctrineTimelineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineTimelineRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(columns: ['entity_class', 'entity_id'])]
class Timeline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $entityClass = null;

    #[ORM\Column]
    private ?int $entityId = null;

    /** @var Collection<int, TimelineItem>  */
    #[ORM\ManyToMany(targetEntity: TimelineItem::class, mappedBy: 'timelines', cascade: ['persist'])]
    #[ORM\OrderBy(['date' => 'DESC'])]
    private Collection $timelineItems;

    public function __construct()
    {
        $this->timelineItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityClass(): ?string
    {
        return $this->entityClass;
    }

    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @return Collection<int, TimelineItem>
     */
    public function getTimelineItems(): Collection
    {
        return $this->timelineItems;
    }

    public function addTimelineItem(TimelineItem $timelineItem): void
    {
        if (!$this->timelineItems->contains($timelineItem)) {
            $this->timelineItems->add($timelineItem);
            $timelineItem->addTimeline($this);
        }
    }

    public function removeTimelineItem(TimelineItem $timelineItem): void
    {
        if ($this->timelineItems->removeElement($timelineItem)) {
            $timelineItem->removeTimeline($this);
        }
    }
}
