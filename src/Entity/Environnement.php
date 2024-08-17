<?php

namespace App\Entity;

use App\Repository\EnvironnementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvironnementRepository::class)]
class Environnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomSite = null;

    #[ORM\Column(length: 255)]
    private ?string $distance = null;

    #[ORM\Column(length: 255)]
    private ?string $est = null;

    #[ORM\Column(length: 255)]
    private ?string $observation = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'Environnement')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
 public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nomSite;
    }

    public function setNomSite(string $nomSite): static
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getEst(): ?string
    {
        return $this->est;
    }

    public function setEst(string $est): static
    {
        $this->est = $est;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }
}
