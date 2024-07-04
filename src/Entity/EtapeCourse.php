<?php

namespace App\Entity;

use App\Repository\EtapeCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeCourseRepository::class)]
class EtapeCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbrCoureur = null;

    #[ORM\Column(length: 155)]
    private ?string $nomEtape = null;

    #[ORM\Column]
    private ?float $longueur = null;

    #[ORM\ManyToOne(inversedBy: 'etapeCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    /**
     * @var Collection<int, PointRang>
     */
    #[ORM\OneToMany(targetEntity: PointRang::class, mappedBy: 'etapeCourse', orphanRemoval: true)]
    private Collection $pointRangs;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $depart = null;

    #[ORM\Column]
    private ?int $rangEtape = null;

    /**
     * @var Collection<int, Classement>
     */
    #[ORM\OneToMany(targetEntity: Classement::class, mappedBy: 'etapeCourse', orphanRemoval: true)]
    private Collection $classements;

    /**
     * @var Collection<int, ClassementCategorie>
     */
    #[ORM\OneToMany(targetEntity: ClassementCategorie::class, mappedBy: 'etapeCourse', orphanRemoval: true)]
    private Collection $classementCategories;

    /**
     * 
     */
    private ?array $classementsEquipe;

    public function getClassementsEquipe() : array
    {
        return $this->classementsEquipe;
    }

    public function setClassementsEquipe(?array $classementsEquipe) : static
    {
        $this->classementsEquipe = $classementsEquipe;

        return $this;
    }

    /**
     * @var Collection<int, Penalite>
     */
    #[ORM\OneToMany(targetEntity: Penalite::class, mappedBy: 'etapeCourse', orphanRemoval: true)]
    private Collection $penalites;

    public function __construct()
    {
        $this->pointRangs = new ArrayCollection();
        $this->classements = new ArrayCollection();
        $this->classementCategories = new ArrayCollection();
        $this->penalites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrCoureur(): ?int
    {
        return $this->nbrCoureur;
    }

    public function setNbrCoureur(int $nbrCoureur): static
    {
        $this->nbrCoureur = $nbrCoureur;

        return $this;
    }

    public function getNomEtape(): ?string
    {
        return $this->nomEtape;
    }

    public function setNomEtape(string $nomEtape): static
    {
        $this->nomEtape = $nomEtape;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, PointRang>
     */
    public function getPointRangs(): Collection
    {
        return $this->pointRangs;
    }

    public function addPointRang(PointRang $pointRang): static
    {
        if (!$this->pointRangs->contains($pointRang)) {
            $this->pointRangs->add($pointRang);
            $pointRang->setEtapeCourse($this);
        }

        return $this;
    }

    public function removePointRang(PointRang $pointRang): static
    {
        if ($this->pointRangs->removeElement($pointRang)) {
            // set the owning side to null (unless already changed)
            if ($pointRang->getEtapeCourse() === $this) {
                $pointRang->setEtapeCourse(null);
            }
        }

        return $this;
    }

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(?\DateTimeInterface $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    public function getRangEtape(): ?int
    {
        return $this->rangEtape;
    }

    public function setRangEtape(?int $rangEtape): static
    {
        $this->rangEtape = $rangEtape;

        return $this;
    }

    /**
     * @return Collection<int, Classement>
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): static
    {
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
            $classement->setEtapeCourse($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): static
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getEtapeCourse() === $this) {
                $classement->setEtapeCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClassementCategorie>
     */
    public function getClassementCategories(): Collection
    {
        return $this->classementCategories;
    }

    public function addClassementCategory(ClassementCategorie $classementCategory): static
    {
        if (!$this->classementCategories->contains($classementCategory)) {
            $this->classementCategories->add($classementCategory);
            $classementCategory->setEtapeCourse($this);
        }

        return $this;
    }

    public function removeClassementCategory(ClassementCategorie $classementCategory): static
    {
        if ($this->classementCategories->removeElement($classementCategory)) {
            // set the owning side to null (unless already changed)
            if ($classementCategory->getEtapeCourse() === $this) {
                $classementCategory->setEtapeCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Penalite>
     */
    public function getPenalites(): Collection
    {
        return $this->penalites;
    }

    public function addPenalite(Penalite $penalite): static
    {
        if (!$this->penalites->contains($penalite)) {
            $this->penalites->add($penalite);
            $penalite->setEtapeCourse($this);
        }

        return $this;
    }

    public function removePenalite(Penalite $penalite): static
    {
        if ($this->penalites->removeElement($penalite)) {
            // set the owning side to null (unless already changed)
            if ($penalite->getEtapeCourse() === $this) {
                $penalite->setEtapeCourse(null);
            }
        }

        return $this;
    }
}
