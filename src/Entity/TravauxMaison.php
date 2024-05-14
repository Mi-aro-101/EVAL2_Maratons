<?php

namespace App\Entity;

use App\Repository\TravauxMaisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravauxMaisonRepository::class)]
class TravauxMaison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'travauxMaisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMaison $typeMaison = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Travaux $travaux = null;

    #[ORM\Column]
    private ?float $duree = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getTypeMaison(): ?TypeMaison
    {
        return $this->typeMaison;
    }

    public function setTypeMaison(?TypeMaison $typeMaison): static
    {
        $this->typeMaison = $typeMaison;

        return $this;
    }

    public function getTravaux(): ?Travaux
    {
        return $this->travaux;
    }

    public function setTravaux(?Travaux $travaux): static
    {
        $this->travaux = $travaux;

        return $this;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): static
    {
        $this->duree = $duree;

        return $this;
    }
}
