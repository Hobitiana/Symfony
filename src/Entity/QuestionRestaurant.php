<?php

namespace App\Entity;

use App\Repository\QuestionRestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRestaurantRepository::class)]
class QuestionRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Questions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestions(): ?string
    {
        return $this->Questions;
    }

    public function setQuestions(string $Questions): static
    {
        $this->Questions = $Questions;

        return $this;
    }
}
