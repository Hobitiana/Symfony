<?php

namespace App\Entity;

use App\Repository\DescriptionQuestionChoixHebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionQuestionChoixHebergementRepository::class)]
class DescriptionQuestionChoixHebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: DescriptionQuestionChoixHebergementDetail::class, mappedBy: 'DescriptionQuestionChoixHebergement', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $details;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'DescriptionQuestionChoixHebergement')]
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

    public function addDetail(DescriptionQuestionChoixHebergementDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setDescriptionQuestionChoixHebergement($this);
        }

        return $this;
    }

    public function removeDetail(DescriptionQuestionChoixHebergementDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            if ($detail->getDescriptionQuestionChoixHebergement() === $this) {
                $detail->setDescriptionQuestionChoixHebergement(null);
            }
        }

        return $this;
    }
}
