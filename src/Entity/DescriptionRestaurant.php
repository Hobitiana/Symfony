<?php

namespace App\Entity;

use App\Repository\DescriptionRestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionRestaurantRepository::class)]
class DescriptionRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: DescriptionRestaurantDetail::class, mappedBy: 'DescriptionRestaurant', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $details;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'DescriptionRestaurant')]
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

    public function addDetail(DescriptionRestaurantDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setDescriptionRestaurant($this);
        }

        return $this;
    }

    public function removeDetail(DescriptionRestaurantDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getDescriptionRestaurant() === $this) {
                $detail->setDescriptionRestaurant(null);
            }
        }

        return $this;
    }
}
