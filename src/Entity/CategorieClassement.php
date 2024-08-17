<?php

namespace App\Entity;

use App\Repository\CategorieClassementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieClassementRepository::class)]
class CategorieClassement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ravinalaSelection = null;

    #[ORM\Column(length: 255)]
    private ?string $etoileSelection = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'CategorieClassement')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRavinalaSelection(): ?string
    {
        return $this->ravinalaSelection;
    }

    public function setRavinalaSelection(string $ravinalaSelection): static
    {
        $this->ravinalaSelection = $ravinalaSelection;

        return $this;
    }

    public function getEtoileSelection(): ?string
    {
        return $this->etoileSelection;
    }

    public function setEtoileSelection(string $etoileSelection): static
    {
        $this->etoileSelection = $etoileSelection;

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
