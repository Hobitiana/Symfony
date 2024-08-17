<?php

namespace App\Entity;

use App\Repository\LieuImplantationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuImplantationRepository::class)]
class LieuImplantation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $commune = null;

    #[ORM\Column(length: 255)]
    private ?string $fivondronana = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $faritany = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'LieuImplantation')]
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getFivondronana(): ?string
    {
        return $this->fivondronana;
    }

    public function setFivondronana(string $fivondronana): static
    {
        $this->fivondronana = $fivondronana;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getFaritany(): ?string
    {
        return $this->faritany;
    }

    public function setFaritany(string $faritany): static
    {
        $this->faritany = $faritany;

        return $this;
    }
}
