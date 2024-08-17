<?php

namespace App\Entity;

use App\Repository\RenseignementEntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementEntrepriseRepository::class)]
class RenseignementEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $denominationSocial = null;

    #[ORM\Column(length: 255)]
    private ?string $enseigneCommercial = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseEntreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $registreCommerce = null;

    #[ORM\Column(length: 255)]
    private ?string $telephoneEntreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $mailEntreprise = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementEntreprise')]
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

    public function getDenominationSocial(): ?string
    {
        return $this->denominationSocial;
    }

    public function setDenominationSocial(string $denominationSocial): static
    {
        $this->denominationSocial = $denominationSocial;

        return $this;
    }

    public function getEnseigneCommercial(): ?string
    {
        return $this->enseigneCommercial;
    }

    public function setEnseigneCommercial(string $enseigneCommercial): static
    {
        $this->enseigneCommercial = $enseigneCommercial;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(string $adresseEntreprise): static
    {
        $this->adresseEntreprise = $adresseEntreprise;

        return $this;
    }

    public function getRegistreCommerce(): ?string
    {
        return $this->registreCommerce;
    }

    public function setRegistreCommerce(string $registreCommerce): static
    {
        $this->registreCommerce = $registreCommerce;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephoneEntreprise;
    }

    public function setTelephoneEntreprise(string $telephoneEntreprise): static
    {
        $this->telephoneEntreprise = $telephoneEntreprise;

        return $this;
    }

    public function getMailEntreprise(): ?string
    {
        return $this->mailEntreprise;
    }

    public function setMailEntreprise(string $mailEntreprise): static
    {
        $this->mailEntreprise = $mailEntreprise;

        return $this;
    }
}
