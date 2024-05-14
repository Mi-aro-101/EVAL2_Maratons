<?php

namespace App\Entity;

use App\Repository\TravauxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravauxRepository::class)]
class Travaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $prixUnitaire = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'travauxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeTravaux $typeTravaux = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Unite $unite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(string $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getTypeTravaux(): ?TypeTravaux
    {
        return $this->typeTravaux;
    }

    public function setTypeTravaux(?TypeTravaux $typeTravaux): static
    {
        $this->typeTravaux = $typeTravaux;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): static
    {
        $this->unite = $unite;

        return $this;
    }
}
