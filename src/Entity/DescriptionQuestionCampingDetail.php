<?php

namespace App\Entity;

use App\Repository\DescriptionQuestionCampingDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionQuestionCampingDetailRepository::class)]
class DescriptionQuestionCampingDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $reponse = null;


    #[ORM\ManyToOne(targetEntity: DescriptionQuestionCamping::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DescriptionQuestionCamping $DescriptionQuestionCamping = null;

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

    

    public function getDescriptionQuestionCamping(): ?DescriptionQuestionCamping
    {
        return $this->DescriptionQuestionCamping;
    }

    public function setDescriptionQuestionCamping(?DescriptionQuestionCamping $DescriptionQuestionCamping): self
    {
        $this->DescriptionQuestionCamping = $DescriptionQuestionCamping;
        return $this;
    }
}
