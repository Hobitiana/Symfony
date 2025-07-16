<?php

namespace App\Entity;

use App\Repository\EnregistrementDeMaDemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User; // Ajout de l'import pour l'entité User

#[ORM\Entity(repositoryClass: EnregistrementDeMaDemandeRepository::class)]
class EnregistrementDeMaDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $typedemande = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'EnregistrementDeMaDemande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    // Ajout du constructeur pour initialiser les propriétés si nécessaire
    public function __construct()
    {
        $this->date = new \DateTime(); // Initialiser la date à la date actuelle, si souhaité
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getTypedemande(): ?string
    {
        return $this->typedemande;
    }

    public function setTypedemande(string $typedemande): static
    {
        $this->typedemande = $typedemande;
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
