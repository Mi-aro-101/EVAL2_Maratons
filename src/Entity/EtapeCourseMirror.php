<?php

namespace App\Entity;

use App\Repository\EtapeCourseMirrorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeCourseMirrorRepository::class)]
class EtapeCourseMirror
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etape = null;

    #[ORM\Column(length: 255)]
    private ?string $longueur = null;

    #[ORM\Column(length: 2)]
    private ?string $nbrCoureur = null;

    #[ORM\Column(length: 2)]
    private ?string $rang = null;

    #[ORM\Column(length: 30)]
    private ?string $dateDepart = null;

    #[ORM\Column(length: 30)]
    private ?string $heureDepart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtape(): ?string
    {
        return $this->etape;
    }

    public function setEtape(string $etape): static
    {
        $this->etape = $etape;

        return $this;
    }

    public function getLongueur(): ?string
    {
        return $this->longueur;
    }

    public function setLongueur(string $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getNbrCoureur(): ?string
    {
        return $this->nbrCoureur;
    }

    public function setNbrCoureur(string $nbrCoureur): static
    {
        $this->nbrCoureur = $nbrCoureur;

        return $this;
    }

    public function getRang(): ?string
    {
        return $this->rang;
    }

    public function setRang(string $rang): static
    {
        $this->rang = $rang;

        return $this;
    }

    public function getDateDepart(): ?string
    {
        return $this->dateDepart;
    }

    public function setDateDepart(string $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getHeureDepart(): ?string
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): static
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }
}
