<?php

namespace App\Entity;

use App\Repository\EloquenceContestParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

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
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?EloquenceSubject $subject = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Formation $formation = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EloquenceContest $eloquenceContest = null;

    public function __construct()
    {
        $this->is_active = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
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

    public function __toString(): string {
        return "{$this->getFirstname()} {$this->getLastname()}";
    }

    public function getEloquenceContest(): ?EloquenceContest
    {
        return $this->eloquenceContest;
    }

    public function setEloquenceContest(?EloquenceContest $eloquenceContest): static
    {
        $this->eloquenceContest = $eloquenceContest;

        return $this;
    }

}
