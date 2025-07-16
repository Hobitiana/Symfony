<?php
namespace App\Entity;

use App\Repository\NationaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NationaliteRepository::class)]
class Nationalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomNationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $codeNationalite = null; // Changed to camelCase for consistency

    #[ORM\OneToMany(mappedBy: 'nationalite', targetEntity: RenseignementIndividuelle::class)]
    private Collection $renseignementsIndividuels;

    public function __construct()
    {
        $this->renseignementsIndividuels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomNationalite(): ?string
    {
        return $this->nomNationalite;
    }

    public function setNomNationalite(string $nomNationalite): static
    {
        $this->nomNationalite = $nomNationalite;
        return $this;
    }

    public function getCodeNationalite(): ?string
    {
        return $this->codeNationalite;
    }

    public function setCodeNationalite(string $codeNationalite): static
    {
        $this->codeNationalite = $codeNationalite;
        return $this;
    }

    /**
     * @return Collection<int, RenseignementIndividuelle>
     */
    public function getRenseignementsIndividuels(): Collection
    {
        return $this->renseignementsIndividuels;
    }

    public function addRenseignementIndividuelle(RenseignementIndividuelle $renseignementIndividuelle): static
    {
        if (!$this->renseignementsIndividuels->contains($renseignementIndividuelle)) {
            $this->renseignementsIndividuels->add($renseignementIndividuelle);
            $renseignementIndividuelle->setNationalite($this);
        }

        return $this;
    }

    public function removeRenseignementIndividuelle(RenseignementIndividuelle $renseignementIndividuelle): static
    {
        if ($this->renseignementsIndividuels->removeElement($renseignementIndividuelle)) {
            // set the owning side to null (unless already changed)
            if ($renseignementIndividuelle->getNationalite() === $this) {
                $renseignementIndividuelle->setNationalite(null);
            }
        }

        return $this;
    }
}
