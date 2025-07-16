<?php
// src/Entity/Activite1.php
// src/Entity/Activite1.php

namespace App\Entity;

use App\Repository\Activite1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Activite1Repository::class)]
class Activite1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(targetEntity: GroupeActivite1::class, inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GroupeActivite1 $groupeActivite1 = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idActivite')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGroupeActivite1(): ?GroupeActivite1
    {
        return $this->groupeActivite1;
    }

    public function setGroupeActivite1(?GroupeActivite1 $groupeActivite1): self
    {
        $this->groupeActivite1 = $groupeActivite1;

        return $this;
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
            $maDemande->setIdActivite($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdActivite() === $this) {
                $maDemande->setIdActivite(null);
            }
        }

        return $this;
    }
}

