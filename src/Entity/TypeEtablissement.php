<?php

namespace App\Entity;

use App\Repository\TypeEtablissementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: TypeEtablissementRepository::class)]
#[Broadcast]
class TypeEtablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(type: "json")]
    private array $nature = [];
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'TypeEtablissement')]
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

    public function getNature(): array
    {
        return $this->nature;
    }

    public function setNature(array $nature): self
    {
        $this->nature = $nature;

        return $this;
    }
}
