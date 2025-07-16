<?php

namespace App\Entity;

use App\Repository\GroupeActivite1Repository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: GroupeActivite1Repository::class)]
class GroupeActivite1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'groupeActivite1', targetEntity: Activite1::class)]
    private Collection $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Activite1>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite1 $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setGroupeActivite1($this);
        }

        return $this;
    }

    public function removeActivite(Activite1 $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getGroupeActivite1() === $this) {
                $activite->setGroupeActivite1(null);
            }
        }

        return $this;
    }
}
