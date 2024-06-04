<?php

namespace App\Entity;

use App\Repository\CategorieCoureurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieCoureurRepository::class)]
class CategorieCoureur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
    private ?string $nomCategorie = null;

    /**
     * @var Collection<int, Coureur>
     */
    #[ORM\ManyToMany(targetEntity: Coureur::class, mappedBy: 'categorieCoureur')]
    private Collection $coureurs;

    public function __construct()
    {
        $this->coureurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Coureur>
     */
    public function getCoureurs(): Collection
    {
        return $this->coureurs;
    }

    public function addCoureur(Coureur $coureur): static
    {
        if (!$this->coureurs->contains($coureur)) {
            $this->coureurs->add($coureur);
            $coureur->addCategorieCoureur($this);
        }

        return $this;
    }

    public function removeCoureur(Coureur $coureur): static
    {
        if ($this->coureurs->removeElement($coureur)) {
            $coureur->removeCategorieCoureur($this);
        }

        return $this;
    }
}
