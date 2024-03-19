<?php

namespace App\Entity;

use App\Repository\WinnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WinnerRepository::class)]
class Winner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\ManyToOne(inversedBy: 'list_winners', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Award $award = null;

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

    public function getAward(): ?Award
    {
        return $this->award;
    }

    public function setAward(?Award $award): static
    {
        $this->award = $award;

        return $this;
    }

    public function __toString()
    {
        return "{$this->getFirstname()} {$this->getLastname()}";
    }
}
