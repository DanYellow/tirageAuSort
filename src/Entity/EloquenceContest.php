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

    #[ORM\ManyToMany(targetEntity: EloquenceContestParticipant::class, inversedBy: 'eloquenceContests')]
    #[ORM\OrderBy(['lastname' => 'ASC'])]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->year = date("Y");
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
        }

        return $this;
    }

    public function removeParticipant(EloquenceContestParticipant $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
