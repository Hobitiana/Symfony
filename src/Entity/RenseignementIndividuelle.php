<?php

namespace App\Entity;

use App\Repository\RenseignementIndividuelleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementIndividuelleRepository::class)]
class RenseignementIndividuelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $individuNom = null;

    #[ORM\Column(length: 255)]
    private ?string $individuPrenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseIndividu = null;

    #[ORM\Column(length: 255)]
    private ?string $mailIndividu = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneIndividu = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementIndividuelle')]
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

    public function getIndividuNom(): ?string
    {
        return $this->individuNom;
    }

    public function setIndividuNom(string $individuNom): static
    {
        $this->individuNom = $individuNom;

        return $this;
    }

    public function getIndividuPrenom(): ?string
    {
        return $this->individuPrenom;
    }

    public function setIndividuPrenom(string $individuPrenom): static
    {
        $this->individuPrenom = $individuPrenom;

        return $this;
    }

    public function getAdresseIndividu(): ?string
    {
        return $this->adresseIndividu;
    }

    public function setAdresseIndividu(string $adresseIndividu): static
    {
        $this->adresseIndividu = $adresseIndividu;

        return $this;
    }

    public function getMailIndividu(): ?string
    {
        return $this->mailIndividu;
    }

    public function setMailIndividu(string $mailIndividu): static
    {
        $this->mailIndividu = $mailIndividu;

        return $this;
    }

    public function getPhoneIndividu(): ?string
    {
        return $this->phoneIndividu;
    }

    public function setPhoneIndividu(string $phoneIndividu): static
    {
        $this->phoneIndividu = $phoneIndividu;

        return $this;
    }
}
