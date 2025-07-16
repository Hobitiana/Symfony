<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'communes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?District $district = null;

    #[ORM\OneToMany(mappedBy: 'commune', targetEntity: Fokotany::class)]
    private Collection $fokotanies;

    public function __construct()
    {
        $this->fokotanies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }
    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }
    
    /**
     * @return Collection<int, Fokotany>
     */
    public function getFokotanies(): Collection
    {
        return $this->fokotanies;
    }

    public function addFokotany(Fokotany $fokotany): self
    {
        if (!$this->fokotanies->contains($fokotany)) {
            $this->fokotanies->add($fokotany);
            $fokotany->setCommune($this);
        }

        return $this;
    }

    public function removeFokotany(Fokotany $fokotany): self
    {
        if ($this->fokotanies->removeElement($fokotany)) {
            // set the owning side to null (unless already changed)
            if ($fokotany->getCommune() === $this) {
                $fokotany->setCommune(null);
            }
        }

        return $this;
    }
}
