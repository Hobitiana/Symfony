<?php

namespace App\Entity;

use App\Repository\RenseignementCINRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementCINRepository::class)]
class RenseignementCIN
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numCIN = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCIN = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuCIN = null;

    #[ORM\Column(length: 255)]
    private ?string $duplicataCIN = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuDuplicataCIN = null;

    #[ORM\Column(length: 255)]
    private ?string $profession = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPere = null;

    #[ORM\Column(length: 255)]
    private ?string $nomMere = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementCIN')]
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

    public function getNumCIN(): ?string
    {
        return $this->numCIN;
    }

    public function setNumCIN(string $numCIN): static
    {
        $this->numCIN = $numCIN;

        return $this;
    }

    public function getDateCIN(): ?\DateTimeInterface
    {
        return $this->dateCIN;
    }

    public function setDateCIN(\DateTimeInterface $dateCIN): static
    {
        $this->dateCIN = $dateCIN;

        return $this;
    }

    public function getLieuCIN(): ?string
    {
        return $this->lieuCIN;
    }

    public function setLieuCIN(string $lieuCIN): static
    {
        $this->lieuCIN = $lieuCIN;

        return $this;
    }

    public function getDuplicataCIN(): ?string
    {
        return $this->duplicataCIN;
    }

    public function setDuplicataCIN(string $duplicataCIN): static
    {
        $this->duplicataCIN = $duplicataCIN;

        return $this;
    }

    public function getLieuDuplicataCIN(): ?string
    {
        return $this->lieuDuplicataCIN;
    }

    public function setLieuDuplicataCIN(string $lieuDuplicataCIN): static
    {
        $this->lieuDuplicataCIN = $lieuDuplicataCIN;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getNomPere(): ?string
    {
        return $this->nomPere;
    }

    public function setNomPere(string $nomPere): static
    {
        $this->nomPere = $nomPere;

        return $this;
    }

    public function getNomMere(): ?string
    {
        return $this->nomMere;
    }

    public function setNomMere(string $nomMere): static
    {
        $this->nomMere = $nomMere;

        return $this;
    }
}
