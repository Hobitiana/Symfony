<?php

namespace App\Entity;

use App\Repository\DesignationEquipementRestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesignationEquipementRestaurantRepository::class)]
class DesignationEquipementRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Designation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): static
    {
        $this->Designation = $Designation;

        return $this;
    }
}
