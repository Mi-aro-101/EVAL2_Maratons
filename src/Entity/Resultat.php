<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $etapeRang = null;

    #[ORM\Column(length: 5)]
    private ?string $numeroDossard = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 1)]
    private ?string $genre = null;

    #[ORM\Column(length: 50)]
    private ?string $dateNaissance = null;

    #[ORM\Column(length: 100)]
    private ?string $equipe = null;

    #[ORM\Column(length: 155)]
    private ?string $arrivee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtapeRang(): ?string
    {
        return $this->etapeRang;
    }

    public function setEtapeRang(string $etapeRang): static
    {
        $this->etapeRang = $etapeRang;

        return $this;
    }

    public function getNumeroDossard(): ?string
    {
        return $this->numeroDossard;
    }

    public function setNumeroDossard(string $numeroDossard): static
    {
        $this->numeroDossard = $numeroDossard;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEquipe(): ?string
    {
        return $this->equipe;
    }

    public function setEquipe(string $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getArrivee(): ?string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): static
    {
        $this->arrivee = $arrivee;

        return $this;
    }
}
