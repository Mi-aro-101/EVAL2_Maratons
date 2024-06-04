<?php

namespace App\Entity;

use App\Repository\PenaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PenaliteRepository::class)]
class Penalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'penalites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtapeCourse $etapeCourse = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $equipe = null;

    #[ORM\Column(length: 100)]
    private ?string $temps = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtapeCourse(): ?EtapeCourse
    {
        return $this->etapeCourse;
    }

    public function setEtapeCourse(?EtapeCourse $etapeCourse): static
    {
        $this->etapeCourse = $etapeCourse;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getTemps(): ?string
    {
        return $this->temps;
    }

    public function setTemps(string $temps): static
    {
        $this->temps = $temps;

        return $this;
    }
}
