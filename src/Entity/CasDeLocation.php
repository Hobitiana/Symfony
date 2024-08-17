<?php

namespace App\Entity;

use App\Repository\CasDeLocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasDeLocationRepository::class)]
class CasDeLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomBailleur = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseBailleur = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPreneur = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseDePreneur = null;

    #[ORM\Column(type: 'integer')]
    private ?int $dureeBailleur = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDuSignateur = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateDuSignateur = null;

    #[ORM\Column(length: 255)]
    private ?string $signataire = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'CasDeLocation')]
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
    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBailleur(): ?string
    {
        return $this->nomBailleur;
    }

    public function setNomBailleur(string $nomBailleur): static
    {
        $this->nomBailleur = $nomBailleur;

        return $this;
    }

    public function getAdresseBailleur(): ?string
    {
        return $this->adresseBailleur;
    }

    public function setAdresseBailleur(string $adresseBailleur): static
    {
        $this->adresseBailleur = $adresseBailleur;

        return $this;
    }

    public function getNomPreneur(): ?string
    {
        return $this->nomPreneur;
    }

    public function setNomPreneur(string $nomPreneur): static
    {
        $this->nomPreneur = $nomPreneur;

        return $this;
    }

    public function getAdresseDePreneur(): ?string
    {
        return $this->adresseDePreneur;
    }

    public function setAdresseDePreneur(string $adresseDePreneur): static
    {
        $this->adresseDePreneur = $adresseDePreneur;

        return $this;
    }

    public function getDureeBailleur(): ?int
    {
        return $this->dureeBailleur;
    }

    public function setDureeBailleur(int $dureeBailleur): static
    {
        $this->dureeBailleur = $dureeBailleur;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNomDuSignateur(): ?string
    {
        return $this->nomDuSignateur;
    }

    public function setNomDuSignateur(string $nomDuSignateur): static
    {
        $this->nomDuSignateur = $nomDuSignateur;

        return $this;
    }

    public function getDateDuSignateur(): ?\DateTimeInterface
    {
        return $this->dateDuSignateur;
    }

    public function setDateDuSignateur(\DateTimeInterface $dateDuSignateur): static
    {
        $this->dateDuSignateur = $dateDuSignateur;

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
}