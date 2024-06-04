<?php

namespace App\Entity;

use App\Repository\CoureurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoureurRepository::class)]
class Coureur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
    private ?string $nomCoureur = null;

    #[ORM\Column(length: 15)]
    private ?string $numeroDossard = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'coureurs')]
    private ?Equipe $equipe = null;

    /**
     * @var Collection<int, CategorieCoureur>
     */
    #[ORM\ManyToMany(targetEntity: CategorieCoureur::class, inversedBy: 'coureurs')]
    private Collection $categorieCoureur;

    #[ORM\Column(length: 8)]
    private ?string $genre = null;

    public function __construct()
    {
        $this->categorieCoureur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCoureur(): ?string
    {
        return $this->nomCoureur;
    }

    public function setNomCoureur(string $nomCoureur): static
    {
        $this->nomCoureur = $nomCoureur;

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

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * @return Collection<int, CategorieCoureur>
     */
    public function getCategorieCoureur(): Collection
    {
        return $this->categorieCoureur;
    }

    public function addCategorieCoureur(CategorieCoureur $categorieCoureur): static
    {
        if (!$this->categorieCoureur->contains($categorieCoureur)) {
            $this->categorieCoureur->add($categorieCoureur);
        }

        return $this;
    }

    public function removeCategorieCoureur(CategorieCoureur $categorieCoureur): static
    {
        $this->categorieCoureur->removeElement($categorieCoureur);

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
}
