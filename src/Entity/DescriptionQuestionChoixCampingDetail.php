<?php

namespace App\Entity;

use App\Repository\DescriptionQuestionChoixCampingDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionQuestionChoixCampingDetailRepository::class)]
class DescriptionQuestionChoixCampingDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $reponse = null;


    #[ORM\ManyToOne(targetEntity: DescriptionQuestionChoixCamping::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DescriptionQuestionChoixCamping $DescriptionQuestionChoixCamping = null;

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

    

    public function getDescriptionQuestionChoixCamping(): ?DescriptionQuestionChoixCamping
    {
        return $this->DescriptionQuestionChoixCamping;
    }

    public function setDescriptionQuestionChoixCamping(?DescriptionQuestionChoixCamping $DescriptionQuestionChoixCamping): self
    {
        $this->DescriptionQuestionChoixCamping = $DescriptionQuestionChoixCamping;
        return $this;
    }
}
