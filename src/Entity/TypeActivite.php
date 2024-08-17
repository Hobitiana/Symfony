<?php

namespace App\Entity;

use App\Repository\TypeActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeActiviteRepository::class)]
class TypeActivite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "json")]
    private array $natureActivite = [];
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'TypeActivite')]
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

    public function getNatureActivite(): array
    {
        return $this->natureActivite;
    }

    public function setNatureActivite(array $nature): self
    {
        $this->natureActivite = $nature;

        return $this;
    }
}
