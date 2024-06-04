<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
    private ?string $nomEquipe = null;

    /**
     * @var Collection<int, Coureur>
     */
    #[ORM\OneToMany(targetEntity: Coureur::class, mappedBy: 'equipe')]
    private Collection $coureurs;

    #[ORM\OneToOne(inversedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->coureurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): static
    {
        $this->nomEquipe = $nomEquipe;

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
            $coureur->setEquipe($this);
        }

        return $this;
    }

    public function removeCoureur(Coureur $coureur): static
    {
        if ($this->coureurs->removeElement($coureur)) {
            // set the owning side to null (unless already changed)
            if ($coureur->getEquipe() === $this) {
                $coureur->setEquipe(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
