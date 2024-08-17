<?php

namespace App\Entity;

use App\Repository\NatureOuvrageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NatureOuvrageRepository::class)]
class NatureOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $natureOuvrage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNatureOuvrage(): ?string
    {
        return $this->natureOuvrage;
    }

    public function setNatureOuvrage(string $nature): static
    {
        $this->natureOuvrage = $nature;

        return $this;
    }
}
