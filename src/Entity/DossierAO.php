<?php


namespace App\Entity;

use App\Repository\DossierAORepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierAORepository::class)]
class DossierAO
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $lettreDemande = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $cnaps = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $copieVisaCertifie = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $attestationAssurance = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $attestationFinanciere = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'dossiersAO')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLettreDemande()
    {
        return $this->lettreDemande;
    }

    public function setLettreDemande($lettreDemande): self
    {
        $this->lettreDemande = $lettreDemande;
        return $this;
    }

    public function getCnaps()
    {
        return $this->cnaps;
    }

    public function setCnaps($cnaps): self
    {
        $this->cnaps = $cnaps;
        return $this;
    }

    public function getCopieVisaCertifie()
    {
        return $this->copieVisaCertifie;
    }

    public function setCopieVisaCertifie($copieVisaCertifie): self
    {
        $this->copieVisaCertifie = $copieVisaCertifie;
        return $this;
    }

    public function getAttestationAssurance()
    {
        return $this->attestationAssurance;
    }

    public function setAttestationAssurance($attestationAssurance): self
    {
        $this->attestationAssurance = $attestationAssurance;
        return $this;
    }

    public function getAttestationFinanciere()
    {
        return $this->attestationFinanciere;
    }

    public function setAttestationFinanciere($attestationFinanciere): self
    {
        $this->attestationFinanciere = $attestationFinanciere;
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

    // Méthodes pour récupérer les fichiers en base64
    public function getLettreDemandeBase64(): ?string
    {
        return is_resource($this->lettreDemande) ? base64_encode(stream_get_contents($this->lettreDemande)) : null;
    }

    public function getCnapsBase64(): ?string
    {
        return is_resource($this->cnaps) ? base64_encode(stream_get_contents($this->cnaps)) : null;
    }

    public function getCopieVisaCertifieBase64(): ?string
    {
        return is_resource($this->copieVisaCertifie) ? base64_encode(stream_get_contents($this->copieVisaCertifie)) : null;
    }

    public function getAttestationAssuranceBase64(): ?string
    {
        return is_resource($this->attestationAssurance) ? base64_encode(stream_get_contents($this->attestationAssurance)) : null;
    }

    public function getAttestationFinanciereBase64(): ?string
    {
        return is_resource($this->attestationFinanciere) ? base64_encode(stream_get_contents($this->attestationFinanciere)) : null;
    }
}
