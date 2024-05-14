<?php

namespace App\Entity;

use App\Repository\DevisDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisDetailsRepository::class)]
class DevisDetails
{

    public function getPrixTotal() : float
    {
        $result = 0;
        $result = $this->getQuantiteTravaux()*$this->getPrixUnitaire();
        return $result;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $pourcentageFinition = null;

    #[ORM\Column]
    private ?float $quantiteTravaux = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $prixUnitaire = null;

    #[ORM\ManyToOne(inversedBy: 'devisDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Devis $devis = null;

    #[ORM\Column(length: 255)]
    private ?string $designationTravaux = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentageFinition(): ?string
    {
        return $this->pourcentageFinition;
    }

    public function setPourcentageFinition(string $pourcentageFinition): static
    {
        $this->pourcentageFinition = $pourcentageFinition;

        return $this;
    }

    public function getQuantiteTravaux(): ?float
    {
        return $this->quantiteTravaux;
    }

    public function setQuantiteTravaux(float $quantiteTravaux): static
    {
        $this->quantiteTravaux = $quantiteTravaux;

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

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): static
    {
        $this->devis = $devis;

        return $this;
    }

    public function getDesignationTravaux(): ?string
    {
        return $this->designationTravaux;
    }

    public function setDesignationTravaux(string $designationTravaux): static
    {
        $this->designationTravaux = $designationTravaux;

        return $this;
    }
}
