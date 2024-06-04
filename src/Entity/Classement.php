<?php

namespace App\Entity;

use App\Repository\ClassementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassementRepository::class)]
class Classement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coureur $coureur = null;

    #[ORM\Column]
    private ?int $rang = null;

    #[ORM\Column]
    private ?float $point = null;

    #[ORM\ManyToOne(inversedBy: 'classements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtapeCourse $etapeCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoureur(): ?Coureur
    {
        return $this->coureur;
    }

    public function setCoureur(?Coureur $coureur): static
    {
        $this->coureur = $coureur;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(int $rang): static
    {
        $this->rang = $rang;

        return $this;
    }

    public function getPoint(): ?float
    {
        return $this->point;
    }

    public function setPoint(float $point): static
    {
        $this->point = $point;

        return $this;
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
}
