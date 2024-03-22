<?php

namespace App\Entity;

use App\Repository\EloquenceContestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EloquenceContestRepository::class)]
#[UniqueEntity('year')]
class EloquenceContest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, unique: true)]
    private ?int $year = null;

    #[ORM\OneToMany(targetEntity: EloquenceContestParticipant::class, mappedBy: 'eloquenceContest', orphanRemoval: true)]
    #[ORM\OrderBy(["lastname" => "ASC"])]
    private Collection $participants;

    public ?string $file = null;

    public function __construct()
    {
        $this->year = date("Y");
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function __toString(): string {
        return "Concours d'éloquence {$this->getYear()}";
    }

    public function getFile() {
        return "";
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
            $participant->setEloquenceContest($this);
        }

        return $this;
    }

    public function removeParticipant(EloquenceContestParticipant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getEloquenceContest() === $this) {
                $participant->setEloquenceContest(null);
            }
        }

        return $this;
    }
}
