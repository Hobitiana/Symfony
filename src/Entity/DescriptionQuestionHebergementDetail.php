<?php

namespace App\Entity;

use App\Repository\DescriptionQuestionHebergementDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionQuestionHebergementDetailRepository::class)]
class DescriptionQuestionHebergementDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $reponse = null;


    #[ORM\ManyToOne(targetEntity: DescriptionQuestionHebergement::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DescriptionQuestionHebergement $DescriptionQuestionHebergement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;
        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }

    

    public function getDescriptionQuestionHebergement(): ?DescriptionQuestionHebergement
    {
        return $this->DescriptionQuestionHebergement;
    }

    public function setDescriptionQuestionHebergement(?DescriptionQuestionHebergement $DescriptionHebergement): self
    {
        $this->DescriptionQuestionHebergement = $DescriptionHebergement;
        return $this;
    }
}
