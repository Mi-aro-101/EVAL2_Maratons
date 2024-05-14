<?php

namespace App\Entity;

use App\Repository\TypeMaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMaisonRepository::class)]
class TypeMaison
{

    // public function getDureeConstruction() : float
    // {
    //     $result = 0;
    //     foreach($this->getTravauxMaisons() as $travaux){
    //         $result += $travaux->getDuree();
    //     }

    //     return $result;
    // }

    public function getPrixTotal() : float
    {
        $result = 0;
        foreach($this->getTravauxMaisons() as $travaux){
            $result += ($travaux->getTravaux()->getPrixUnitaire() * $travaux->getQuantite());
        }
        return $result;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    /**
     * @var Collection<int, TravauxMaison>
     */
    #[ORM\OneToMany(targetEntity: TravauxMaison::class, mappedBy: 'typeMaison')]
    private Collection $travauxMaisons;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Devis>
     */
    #[ORM\OneToMany(targetEntity: Devis::class, mappedBy: 'typeMaison', orphanRemoval: true)]
    private Collection $devis;

    #[ORM\Column]
    private ?float $dureeConstruction = null;

    #[ORM\Column]
    private ?float $surface = null;

    public function __construct()
    {
        $this->travauxMaisons = new ArrayCollection();
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, TravauxMaison>
     */
    public function getTravauxMaisons(): Collection
    {
        return $this->travauxMaisons;
    }

    public function addTravauxMaison(TravauxMaison $travauxMaison): static
    {
        if (!$this->travauxMaisons->contains($travauxMaison)) {
            $this->travauxMaisons->add($travauxMaison);
            $travauxMaison->setTypeMaison($this);
        }

        return $this;
    }

    public function removeTravauxMaison(TravauxMaison $travauxMaison): static
    {
        if ($this->travauxMaisons->removeElement($travauxMaison)) {
            // set the owning side to null (unless already changed)
            if ($travauxMaison->getTypeMaison() === $this) {
                $travauxMaison->setTypeMaison(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setTypeMaison($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getTypeMaison() === $this) {
                $devi->setTypeMaison(null);
            }
        }

        return $this;
    }

    public function getDureeConstruction(): ?float
    {
        return $this->dureeConstruction;
    }

    public function setDureeConstruction(?float $dureeConstruction): static
    {
        $this->dureeConstruction = $dureeConstruction;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }
}
