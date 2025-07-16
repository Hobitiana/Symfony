<?php

namespace App\Entity;

use App\Repository\DescriptionHebergementDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionHebergementDetailRepository::class)]
class DescriptionHebergementDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $superficie = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre = null;

    #[ORM\ManyToOne(targetEntity: DescriptionHebergement::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DescriptionHebergement $DescriptionHebergement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;
        return $this;
    }

    public function getSuperficie(): ?string
    {
        return $this->superficie;
    }

    public function setSuperficie(?string $superficie): self
    {
        $this->superficie = $superficie;
        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(?int $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescriptionHebergement(): ?DescriptionHebergement
    {
        return $this->DescriptionHebergement;
    }

    public function setDescriptionHebergement(?DescriptionHebergement $DescriptionHebergement): self
    {
        $this->DescriptionHebergement = $DescriptionHebergement;
        return $this;
    }
}
