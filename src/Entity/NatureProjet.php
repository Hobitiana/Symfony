<?php

namespace App\Entity;

use App\Repository\NatureProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NatureProjetRepository::class)]
class NatureProjet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nature = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'natureProjets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idNatureProjet')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
    }
    
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

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(string $nature): static
    {
        $this->nature = $nature;

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
            $maDemande->setIdNatureProjet($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdNatureProjet() === $this) {
                $maDemande->setIdNatureProjet(null);
            }
        }

        return $this;
    }
}
