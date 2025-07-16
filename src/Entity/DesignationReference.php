<?php

namespace App\Entity;

use App\Repository\DesignationReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesignationReferenceRepository::class)]
class DesignationReference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $datesignature = null;

    #[ORM\Column(length: 255)]
    private ?string $signataire = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'DesignationReference')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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

    public function getDatesignature(): ?\DateTimeInterface
    {
        return $this->datesignature;
    }

    public function setDatesignature(?\DateTimeInterface $datesignature): static
    {
        $this->datesignature = $datesignature;

        return $this;
    }
  
    public function getSignataire(): ?string
    {
        return $this->signataire;
    }

    public function setSignataire(string $signataire): static
    {
        $this->signataire = $signataire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
