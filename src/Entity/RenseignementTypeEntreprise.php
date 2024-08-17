<?php

namespace App\Entity;

use App\Repository\RenseignementTypeEntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementTypeEntrepriseRepository::class)]
class RenseignementTypeEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeEntrprise = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementTypeEntreprise')]
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
   
public function getTypeEntrprise(): ?string
{
    return $this->typeEntrprise;
}

public function setTypeEntrprise(string $typeEntrprise): static
{
    $this->typeEntrprise = $typeEntrprise;

    return $this;
}
}
