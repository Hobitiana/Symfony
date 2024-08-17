<?php

namespace App\Entity;

use App\Repository\PlanMasseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanMasseRepository::class)]
class PlanMasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $planMasse = null;

    #[ORM\Column(length: 255)]
    private ?string $planEsquisse = null;

    #[ORM\Column(length: 255)]
    private ?string $planImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $planAssainissement = null;

    #[ORM\Column(length: 255)]
    private ?string $certificatSituationJuridiqueTerrain = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'PlanMasse')]
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

    public function getPlanMasse(): ?string
    {
        return $this->planMasse;
    }

    public function setPlanMasse(string $planMasse): static
    {
        $this->planMasse = $planMasse;

        return $this;
    }

    public function getPlanEsquisse(): ?string
    {
        return $this->planEsquisse;
    }

    public function setPlanEsquisse(string $planEsquisse): static
    {
        $this->planEsquisse = $planEsquisse;

        return $this;
    }

    public function getPlanImmatriculation(): ?string
    {
        return $this->planImmatriculation;
    }

    public function setPlanImmatriculation(string $planImmatriculation): static
    {
        $this->planImmatriculation = $planImmatriculation;

        return $this;
    }

    public function getPlanAssainissement(): ?string
    {
        return $this->planAssainissement;
    }

    public function setPlanAssainissement(string $planAssainissement): static
    {
        $this->planAssainissement = $planAssainissement;

        return $this;
    }

    public function getCertificatSituationJuridiqueTerrain(): ?string
    {
        return $this->certificatSituationJuridiqueTerrain;
    }

    public function setCertificatSituationJuridiqueTerrain(string $certificatSituationJuridiqueTerrain): static
    {
        $this->certificatSituationJuridiqueTerrain = $certificatSituationJuridiqueTerrain;

        return $this;
    }
}
