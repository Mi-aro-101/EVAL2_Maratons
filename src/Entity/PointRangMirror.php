<?php

namespace App\Entity;

use App\Repository\PointRangMirrorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRangMirrorRepository::class)]
class PointRangMirror
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?string $classement = null;

    #[ORM\Column(length: 10)]
    private ?string $points = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassement(): ?string
    {
        return $this->classement;
    }

    public function setClassement(string $classement): static
    {
        $this->classement = $classement;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): static
    {
        $this->points = $points;

        return $this;
    }
}
