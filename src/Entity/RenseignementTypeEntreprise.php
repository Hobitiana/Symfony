<?php

namespace App\Entity;

use App\Repository\RenseignementTypeEntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementTypeEntrepriseRepository::class)]
class RenseignementTypeEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeEntrprise = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'RenseignementTypeEntreprise')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idRenseignementEntreprise')]
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
   
public function getTypeEntrprise(): ?string
{
    return $this->typeEntrprise;
}

public function setTypeEntrprise(string $typeEntrprise): static
{
    $this->typeEntrprise = $typeEntrprise;

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
        $maDemande->setIdRenseignementEntreprise($this);
    }

    return $this;
}

public function removeMaDemande(MaDemande $maDemande): static
{
    if ($this->maDemandes->removeElement($maDemande)) {
        // set the owning side to null (unless already changed)
        if ($maDemande->getIdRenseignementEntreprise() === $this) {
            $maDemande->setIdRenseignementEntreprise(null);
        }
    }

    return $this;
}
}
