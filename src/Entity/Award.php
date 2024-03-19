<?php

namespace App\Entity;

use App\Repository\AwardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

enum AwardCategory: string {
    case Jury = 'jury';
    case Public = 'public';
}

#[ORM\Entity(repositoryClass: AwardRepository::class)]
class Award
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, type: 'string', enumType: AwardCategory::class)]
    private ?AwardCategory $category = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $year = null;

    #[ORM\ManyToMany(targetEntity: Winner::class, inversedBy: 'list_awards')]
    private Collection $list_winners;

    public function __construct()
    {
        $this->list_winners = new ArrayCollection();
        $this->category = AwardCategory::Jury;
        $this->year = date("Y");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?AwardCategory
    {
        return $this->category;
    }

    public function setCategory(AwardCategory $category): static
    {
        $this->category = $category->value;

        return $this;
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

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Winner>
     */
    public function getListWinners(): Collection
    {
        return $this->list_winners;
    }

    public function addListWinner(Winner $listWinner): static
    {
        if (!$this->list_winners->contains($listWinner)) {
            $this->list_winners->add($listWinner);
        }

        return $this;
    }

    public function removeListWinner(Winner $listWinner): static
    {
        $this->list_winners->removeElement($listWinner);

        return $this;
    }
}
