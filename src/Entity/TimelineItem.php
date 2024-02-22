<?php
declare(strict_types=1);

namespace Damecode\TimelineBundle\Entity;

use Damecode\TimelineBundle\Repository\DoctrineTimelineItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineTimelineItemRepository::class)]
#[ORM\MappedSuperclass]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([])]
abstract class TimelineItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /** @var Collection<int, Timeline> */
    #[ORM\ManyToMany(targetEntity: Timeline::class, inversedBy: 'timelineItems')]
    private Collection $timelines;

    public function __construct()
    {
        $this->timelines = new ArrayCollection();
        $this->date = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Collection<int, Timeline>
     */
    public function getTimelines(): Collection
    {
        return $this->timelines;
    }

    public function addTimeline(Timeline $timeline): void
    {
        if (!$this->timelines->contains($timeline)) {
            $this->timelines->add($timeline);
        }
    }

    public function removeTimeline(Timeline $timeline): void
    {
        $this->timelines->removeElement($timeline);
    }
}
