<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlanMasseRepository;

#[ORM\Entity(repositoryClass: PlanMasseRepository::class)]
class PlanMasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $planMasse = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $planEsquisse = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $planImmatriculation = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $planAssainissement = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $certificatSituationJuridiqueTerrain = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'plansMasse')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idPlanMasse')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanMasse()
    {
        return $this->planMasse;
    }

    public function setPlanMasse($planMasse): self
    {
        $this->planMasse = $planMasse;
        return $this;
    }

    public function getPlanEsquisse()
    {
        return $this->planEsquisse;
    }

    public function setPlanEsquisse($planEsquisse): self
    {
        $this->planEsquisse = $planEsquisse;
        return $this;
    }

    public function getPlanImmatriculation()
    {
        return $this->planImmatriculation;
    }

    public function setPlanImmatriculation($planImmatriculation): self
    {
        $this->planImmatriculation = $planImmatriculation;
        return $this;
    }

    public function getPlanAssainissement()
    {
        return $this->planAssainissement;
    }

    public function setPlanAssainissement($planAssainissement): self
    {
        $this->planAssainissement = $planAssainissement;
        return $this;
    }

    public function getCertificatSituationJuridiqueTerrain()
    {
        return $this->certificatSituationJuridiqueTerrain;
    }

    public function setCertificatSituationJuridiqueTerrain($certificatSituationJuridiqueTerrain): self
    {
        $this->certificatSituationJuridiqueTerrain = $certificatSituationJuridiqueTerrain;
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

    // Methods for retrieving files as base64
    public function getPlanMasseBase64(): ?string
    {
        return is_resource($this->planMasse) ? base64_encode(stream_get_contents($this->planMasse)) : null;
    }

    public function getPlanEsquisseBase64(): ?string
    {
        return is_resource($this->planEsquisse) ? base64_encode(stream_get_contents($this->planEsquisse)) : null;
    }

    public function getPlanImmatriculationBase64(): ?string
    {
        return is_resource($this->planImmatriculation) ? base64_encode(stream_get_contents($this->planImmatriculation)) : null;
    }

    public function getPlanAssainissementBase64(): ?string
    {
        return is_resource($this->planAssainissement) ? base64_encode(stream_get_contents($this->planAssainissement)) : null;
    }

    public function getCertificatSituationJuridiqueTerrainBase64(): ?string
    {
        return is_resource($this->certificatSituationJuridiqueTerrain) ? base64_encode(stream_get_contents($this->certificatSituationJuridiqueTerrain)) : null;
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
            $maDemande->setIdPlanMasse($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdPlanMasse() === $this) {
                $maDemande->setIdPlanMasse(null);
            }
        }

        return $this;
    }
}
