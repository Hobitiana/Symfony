<?php

namespace App\Entity;

use App\Repository\ResultatDemandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatDemandeRepository::class)]
class ResultatDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ResultatDemande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: ResultatDemande::class, inversedBy: 'maDemandes')]
    #[ORM\JoinColumn(nullable: false)] // Mettre `nullable: true` si ce champ est optionnel
    private ?ResultatDemande $idDemande = null;

     public function getUser(): ?User
    {
        return $this->user;
    }

    public function __toString(): string
    {
        return $this->reference;
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }
    public function getIdDemande(): ?ResultatDemande
    {
        return $this->idDemande;
    }

    public function setIdDemande(?ResultatDemande $idDemande): static
    {
        $this->idDemande = $idDemande;

        return $this;
    }
}
