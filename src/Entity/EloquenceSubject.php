<?php

namespace App\Entity;

use App\Repository\EloquenceSubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EloquenceSubjectRepository::class)]
class EloquenceSubject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $year = null;

    #[ORM\OneToMany(targetEntity: EloquenceContestParticipant::class, mappedBy: 'subject')]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->year = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, EloquenceContestParticipant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(EloquenceContestParticipant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setSubject($this);
        }

        return $this;
    }

    public function removeParticipant(EloquenceContestParticipant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getSubject() === $this) {
                $participant->setSubject(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
