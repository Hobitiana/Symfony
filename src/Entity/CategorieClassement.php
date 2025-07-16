<?php

namespace App\Entity;

use App\Repository\CategorieClassementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieClassementRepository::class)]
class CategorieClassement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ravinalaSelection = null;

    #[ORM\Column(length: 255)]
    private ?string $etoileSelection = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'CategorieClassement')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idCategorieClassement')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRavinalaSelection(): ?string
    {
        return $this->ravinalaSelection;
    }

    public function setRavinalaSelection(string $ravinalaSelection): static
    {
        $this->ravinalaSelection = $ravinalaSelection;

        return $this;
    }

    public function getEtoileSelection(): ?string
    {
        return $this->etoileSelection;
    }

    public function setEtoileSelection(string $etoileSelection): static
    {
        $this->etoileSelection = $etoileSelection;

        return $this;
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
            $maDemande->setIdCategorieClassement($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdCategorieClassement() === $this) {
                $maDemande->setIdCategorieClassement(null);
            }
        }

        return $this;
    }
}
