<?php

namespace App\Entity;

use App\Repository\DesignationCampingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesignationCampingRepository::class)]
class DesignationCamping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }
}
