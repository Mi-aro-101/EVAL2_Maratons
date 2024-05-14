<?php

namespace App\Entity;

use App\Repository\TypeTravauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeTravauxRepository::class)]
class TypeTravaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $designation = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    /**
     * @var Collection<int, Travaux>
     */
    #[ORM\OneToMany(targetEntity: Travaux::class, mappedBy: 'typeTravaux')]
    private Collection $travauxes;

    public function __construct()
    {
        $this->travauxes = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Travaux>
     */
    public function getTravauxes(): Collection
    {
        return $this->travauxes;
    }

    public function addTravaux(Travaux $travaux): static
    {
        if (!$this->travauxes->contains($travaux)) {
            $this->travauxes->add($travaux);
            $travaux->setTypeTravaux($this);
        }

        return $this;
    }

    public function removeTravaux(Travaux $travaux): static
    {
        if ($this->travauxes->removeElement($travaux)) {
            // set the owning side to null (unless already changed)
            if ($travaux->getTypeTravaux() === $this) {
                $travaux->setTypeTravaux(null);
            }
        }

        return $this;
    }
}
