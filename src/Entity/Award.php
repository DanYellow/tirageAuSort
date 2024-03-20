<?php

namespace App\Entity;

use App\Repository\AwardRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

enum AwardCategory: string {
    case Jury = 'jury';
    case Public = 'public';
}

// #[UniqueEntity('slug')]
#[ORM\Entity(repositoryClass: AwardRepository::class)]
#[ORM\UniqueConstraint(
    name: 'award_unique',
    columns: ['year', 'slug']
  )]
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

    #[ORM\OneToMany(targetEntity: Winner::class, mappedBy: 'award')]
    #[ORM\OrderBy(['lastname' => 'ASC'])]
    private Collection $list_winners;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->category = AwardCategory::Jury;
        $this->year = date("Y");
        $this->list_winners = new ArrayCollection();
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
        $this->category = $category;

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
            $listWinner->setAward($this);
        }

        return $this;
    }

    public function removeListWinner(Winner $listWinner): static
    {
        if ($this->list_winners->removeElement($listWinner)) {
            // set the owning side to null (unless already changed)
            if ($listWinner->getAward() === $this) {
                $listWinner->setAward(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = strtolower($slug);

        return $this;
    }
}
