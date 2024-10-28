<?php

namespace App\Entity;

use App\Repository\RenseignementEntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RenseignementEntrepriseRepository::class)]
class RenseignementEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Denomination sociale is required.')]
    private ?string $denominationSociale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enseigneCommerciale = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Adresse entreprise is required.')]
    private ?string $adresseEntreprise = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Registre commerce is required.')]
    private ?string $registreCommerce = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'Telephone entreprise is required.')]
    #[Assert\Regex('/^\+?[0-9]{7,15}$/', message: 'Invalid phone number format.')]
    private ?string $telephoneEntreprise = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email entreprise is required.')]
    #[Assert\Email(message: 'Invalid email format.')]
    private ?string $mailEntreprise = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Registre commerce is required.')]
    private ?string $nomMandataire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Registre commerce is required.')]
    private ?string $prenomMandataire = null;

    #[ORM\ManyToOne(targetEntity: Nationalite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nationalite $nationalite = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'renseignementEntreprises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenominationSociale(): ?string
    {
        return $this->denominationSociale;
    }

    public function setDenominationSociale(string $denominationSociale): self
    {
        $this->denominationSociale = $denominationSociale;

        return $this;
    }

    public function getEnseigneCommerciale(): ?string
    {
        return $this->enseigneCommerciale;
    }

    public function setEnseigneCommerciale(?string $enseigneCommerciale): self
    {
        $this->enseigneCommerciale = $enseigneCommerciale;

        return $this;
    }
    public function getNomMandataire(): ?string
    {
        return $this->nomMandataire;
    }

    public function setNomMandataire(?string $nomMandataire): self
    {
        $this->nomMandataire = $nomMandataire;

        return $this;
    }
    public function getPrenomMandataire(): ?string
    {
        return $this->prenomMandataire;
    }

    public function setPrenomMandataire(?string $prenomMandataire): self
    {
        $this->prenomMandataire = $prenomMandataire;

        return $this;
    }
    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): static
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(string $adresseEntreprise): self
    {
        $this->adresseEntreprise = $adresseEntreprise;

        return $this;
    }

    public function getRegistreCommerce(): ?string
    {
        return $this->registreCommerce;
    }

    public function setRegistreCommerce(string $registreCommerce): self
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephoneEntreprise;
    }

    public function setTelephoneEntreprise(string $telephoneEntreprise): self
    {
        $this->telephoneEntreprise = $telephoneEntreprise;

        return $this;
    }

    public function getMailEntreprise(): ?string
    {
        return $this->mailEntreprise;
    }

    public function setMailEntreprise(string $mailEntreprise): self
    {
        $this->mailEntreprise = $mailEntreprise;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
