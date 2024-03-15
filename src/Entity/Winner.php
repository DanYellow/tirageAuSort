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

    #[ORM\ManyToMany(targetEntity: Award::class, mappedBy: 'list_winners')]
    private Collection $list_awards;

    public function __construct()
    {
        $this->list_awards = new ArrayCollection();
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

    /**
     * @return Collection<int, Award>
     */
    public function getListAwards(): Collection
    {
        return $this->list_awards;
    }

    public function addListAward(Award $listAward): static
    {
        if (!$this->list_awards->contains($listAward)) {
            $this->list_awards->add($listAward);
            $listAward->addListWinner($this);
        }

        return $this;
    }

    public function removeListAward(Award $listAward): static
    {
        if ($this->list_awards->removeElement($listAward)) {
            $listAward->removeListWinner($this);
        }

        return $this;
    }
}
