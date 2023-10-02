<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[UniqueEntity('code')]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
class Event
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Versioned]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(allowNull: true)]
    #[Gedmo\Versioned]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Versioned]
    private $location;

    #[ORM\Column(type: 'text')]
    #[Gedmo\Versioned]
    private $description;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Versioned]
    private $startAt;

    #[ORM\ManyToMany(targetEntity: Member::class, inversedBy: 'events')]
    #[ORM\OrderBy(['lastName' => 'ASC', 'firstName' => 'ASC'])]
    private $attendees;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getAttendees(): Collection
    {
        return $this->attendees;
    }

    public function addAttendee(Member $attendee): self
    {
        if (!$this->attendees->contains($attendee)) {
            $this->attendees[] = $attendee;
        }

        return $this;
    }

    public function removeAttendee(Member $attendee): self
    {
        $this->attendees->removeElement($attendee);

        return $this;
    }

    /* Model Methods */

    public function __toString(): string
    {
        return sprintf(
            '%s: %s',
            $this->startAt->format('n/j/Y'),
            $this->name
        );
    }

    #[ORM\PreFlush]
    public function updateFieldsIfBlank()
    {
        if (!$this->code) {
            $this->code = md5($this);
        }
    }
}
