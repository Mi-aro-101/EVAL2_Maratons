<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
    private ?string $nomCourse = null;

    /**
     * @var Collection<int, EtapeCourse>
     */
    #[ORM\OneToMany(targetEntity: EtapeCourse::class, mappedBy: 'course')]
    private Collection $etapeCourses;

    public function __construct()
    {
        $this->etapeCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id) : static
    {
        $this->id = $id;

        return $this;
    }

    public function getNomCourse(): ?string
    {
        return $this->nomCourse;
    }

    public function setNomCourse(string $nomCourse): static
    {
        $this->nomCourse = $nomCourse;

        return $this;
    }

    /**
     * @return Collection<int, EtapeCourse>
     */
    public function getEtapeCourses(): Collection
    {
        return $this->etapeCourses;
    }

    public function addEtapeCourse(EtapeCourse $etapeCourse): static
    {
        if (!$this->etapeCourses->contains($etapeCourse)) {
            $this->etapeCourses->add($etapeCourse);
            $etapeCourse->setCourse($this);
        }

        return $this;
    }

    public function removeEtapeCourse(EtapeCourse $etapeCourse): static
    {
        if ($this->etapeCourses->removeElement($etapeCourse)) {
            // set the owning side to null (unless already changed)
            if ($etapeCourse->getCourse() === $this) {
                $etapeCourse->setCourse(null);
            }
        }

        return $this;
    }
}
