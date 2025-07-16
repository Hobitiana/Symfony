<?php

namespace App\Entity;

use App\Repository\DescriptionQuestionHebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionQuestionHebergementRepository::class)]
class DescriptionQuestionHebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: DescriptionQuestionHebergementDetail::class, mappedBy: 'DescriptionQuestionHebergement', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $details;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'DescriptionQuestionHebergement')]
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

    public function addDetail(DescriptionQuestionHebergementDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setDescriptionQuestionHebergement($this);
        }

        return $this;
    }

    public function removeDetail(DescriptionQuestionHebergementDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getDescriptionQuestionHebergement() === $this) {
                $detail->setDescriptionQuestionHebergement(null);
            }
        }

        return $this;
    }
}
