<?php

namespace App\Entity;

use App\Repository\TypeConstructionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeConstructionRepository::class)]
class TypeConstruction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: TypeConstructionDetail::class, mappedBy: 'typeConstruction', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $details;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'TypeConstruction')]
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

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(TypeConstructionDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setTypeConstruction($this);
        }

        return $this;
    }

    public function removeDetail(TypeConstructionDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getTypeConstruction() === $this) {
                $detail->setTypeConstruction(null);
            }
        }

        return $this;
    }
}
