<?php

namespace App\Entity;

use App\Repository\RenseignementResponsableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementResponsableRepository::class)]
class RenseignementResponsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementResponsable')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $responsable = null;
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
    
    public function getResponsable(): String
    {
        return $this->responsable;
    }

    public function setResponsable(String $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }
}
