<?php

namespace App\Entity;

use App\Repository\ActiviteRestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRestaurantRepository::class)]
class ActiviteRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $activite = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ActiviteRestaurant')]
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

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): static
    {
        $this->activite = $activite;

        return $this;
    }
}
