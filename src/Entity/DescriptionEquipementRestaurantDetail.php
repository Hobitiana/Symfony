<?php

namespace App\Entity;

use App\Repository\DescriptionEquipementRestaurantDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DescriptionEquipementRestaurantDetailRepository::class)]
class DescriptionEquipementRestaurantDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;


    #[ORM\Column(nullable: true)]
    private ?int $nombre = null;

    #[ORM\ManyToOne(targetEntity: DescriptionEquipementRestaurant::class, inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DescriptionEquipementRestaurant $DescriptionRestaurant = null;

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


    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(?int $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescriptionEquipementRestaurant(): ?DescriptionEquipementRestaurant
    {
        return $this->DescriptionRestaurant;
    }

    public function setDescriptionEquipementRestaurant(?DescriptionEquipementRestaurant $DescriptionRestaurant): self
    {
        $this->DescriptionRestaurant = $DescriptionRestaurant;
        return $this;
    }
}
