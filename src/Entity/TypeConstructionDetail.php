<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TypeConstructionDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unite = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre = null;

    #[ORM\ManyToOne(targetEntity: TypeConstruction::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeConstruction $typeConstruction = null;

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

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;
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

    public function getTypeConstruction(): ?TypeConstruction
    {
        return $this->typeConstruction;
    }

    public function setTypeConstruction(?TypeConstruction $typeConstruction): self
    {
        $this->typeConstruction = $typeConstruction;
        return $this;
    }
}
