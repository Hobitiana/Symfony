<?php

namespace App\Entity;

use App\Repository\UploadAvisOuvertureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UploadAvisOuvertureRepository::class)]
class UploadAvisOuverture
{
  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'blob', nullable: true)] 
    private $judiciaire = null;

    #[ORM\Column(type: 'blob', nullable: true)] 
    private $cin = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $visa = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $statuts = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $assurance = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $financiere = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $certificatJuridique = null;

    // Autres propriétés et méthodes...
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'UploadAvisOuverture')]
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
            
    public function getJudiciaire()
    {
        return $this->judiciaire;
    }

    public function setJudiciaire($judiciaire): static
    {
        $this->judiciaire = $judiciaire;

        return $this;
    }

    public function getCin()
    {
        return $this->cin;
    }

    public function setCin($cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getVisa()
    {
        return $this->visa;
    }

    public function setVisa($visa): static
    {
        $this->visa = $visa;

        return $this;
    }

    public function getStatuts()
    {
        return $this->statuts;
    }

    public function setStatuts($statuts): static
    {
        $this->statuts = $statuts;

        return $this;
    }

    public function getAssurance()
    {
        return $this->assurance;
    }

    public function setAssurance($assurance): static
    {
        $this->assurance = $assurance;

        return $this;
    }
    public function getCertificatJuridique()
    {
        return $this->certificatJuridique;
    }

    public function setCertificatJuridique($certificatJuridique): static
    {
        $this->certificatJuridique = $certificatJuridique;

        return $this;
    }
    public function getFinanciere()
    {
        return $this->financiere;
    }

    public function setFinanciere($financiere): static
    {
        $this->financiere = $financiere;

        return $this;
    }
    public function getJudiciaireBase64(): ?string
    {
        return $this->judiciaire ? base64_encode(stream_get_contents($this->judiciaire)) : null;
    }

    public function getCINBase64(): ?string
    {
        return $this->cin ? base64_encode(stream_get_contents($this->cin)) : null;
    }

    public function getVisaBase64(): ?string
    {
        return $this->visa ? base64_encode(stream_get_contents($this->visa)) : null;
    }

    public function getStatutsBase64(): ?string
    {
        return $this->statuts ? base64_encode(stream_get_contents($this->statuts)) : null;
    }

    public function getCertificatJuridiqueBase64(): ?string
    {
        return $this->certificatJuridique ? base64_encode(stream_get_contents($this->certificatJuridique)) : null;
    }
    public function getfinanciereBase64(): ?string
    {
        return $this->financiere ? base64_encode(stream_get_contents($this->financiere)) : null;
    }

    public function getAssuranceBase64(): ?string
    {
        return $this->assurance ? base64_encode(stream_get_contents($this->assurance)) : null;
    }
}
