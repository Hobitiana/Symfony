<?php

namespace App\Entity;

use App\Repository\RenseignementVisaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementVisaRepository::class)]
class RenseignementVisa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numPasseport = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPasseport = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomPasseport = null;


    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $Nationalite = null;


    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $DateDelivrance = null;


    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $Validite = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;
    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementVisa')]
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

    public function getNumPasseport(): ?string
    {
        return $this->numPasseport;
    }

    public function setNumPasseport(string $numPasseport): static
    {
        $this->numPasseport = $numPasseport;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getNomPasseport(): ?string
    {
        return $this->nomPasseport;
    }

    public function setNomPasseport(string $nomPasseport): static
    {
        $this->nomPasseport = $nomPasseport;

        return $this;
    }

    public function getPrenomPasseport(): ?string
    {
        return $this->prenomPasseport;
    }

    public function setPrenomPasseport(string $prenomPasseport): static
    {
        $this->prenomPasseport = $prenomPasseport;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }

    public function setNationalite(string $Nationalite): static
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }

    public function getDateDelivrance(): ?\DateTimeInterface
    {
        return $this->DateDelivrance;
    }

    public function setDateDelivrance(\DateTimeInterface $DateDelivrance): static
    {
        $this->DateDelivrance = $DateDelivrance;

        return $this;
    }

    public function getValidite(): ?\DateTimeInterface
    {
        return $this->Validite;
    }

    public function setValidite(\DateTimeInterface $Validite): static
    {
        $this->Validite = $Validite;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
