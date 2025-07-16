<?php

namespace App\Entity;

use App\Repository\CasDeLocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idCasDeLocation')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
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

    /**
     * @return Collection<int, MaDemande>
     */
    public function getMaDemandes(): Collection
    {
        return $this->maDemandes;
    }

    public function addMaDemande(MaDemande $maDemande): static
    {
        if (!$this->maDemandes->contains($maDemande)) {
            $this->maDemandes->add($maDemande);
            $maDemande->setIdCasDeLocation($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdCasDeLocation() === $this) {
                $maDemande->setIdCasDeLocation(null);
            }
        }

        return $this;
    }
}