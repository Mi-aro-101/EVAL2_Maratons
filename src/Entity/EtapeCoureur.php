<?php

namespace App\Entity;

use App\Repository\EtapeCoureurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeCoureurRepository::class)]
class EtapeCoureur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $arrivee = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coureur $coureur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtapeCourse $etapeCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivee(): ?\DateTimeInterface
    {
        return $this->arrivee;
    }

    public function setArrivee(\DateTimeInterface $arrivee): static
    {
        $this->arrivee = $arrivee;

        return $this;
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
