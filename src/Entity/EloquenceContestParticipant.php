<?php

namespace App\Entity;

use App\Repository\EloquenceContestParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: EloquenceContestParticipantRepository::class)]
class EloquenceContestParticipant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    private ?EloquenceSubject $subject = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    private ?Formation $formation = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: EloquenceContest::class, mappedBy: 'participants')]
    #[MaxDepth(0)]
    private Collection $eloquenceContests;

    public function __construct()
    {
        $this->is_active = false;
        $this->eloquenceContests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSubject(): ?EloquenceSubject
    {
        return $this->subject;
    }

    public function setSubject(?EloquenceSubject $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getFullname(): string {
        return "{$this->getFirstname()} {$this->getLastname()}";
    }

    public function __toString(): string {
        return "{$this->getFirstname()} {$this->getLastname()}";
    }

    /**
     * @return Collection<int, EloquenceContest>
     */
    public function getEloquenceContests(): Collection
    {
        return $this->eloquenceContests;
    }

    public function addEloquenceContest(EloquenceContest $eloquenceContest): static
    {
        if (!$this->eloquenceContests->contains($eloquenceContest)) {
            $this->eloquenceContests->add($eloquenceContest);
            $eloquenceContest->addParticipant($this);
        }

        return $this;
    }

    public function removeEloquenceContest(EloquenceContest $eloquenceContest): static
    {
        if ($this->eloquenceContests->removeElement($eloquenceContest)) {
            $eloquenceContest->removeParticipant($this);
        }

        return $this;
    }
}
