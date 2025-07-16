<?php

namespace App\Entity;

use App\Repository\QuestionCampingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionCampingRepository::class)]
class QuestionCamping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 500)]
    private ?string $questions = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getQuestions(): ?string
    {
        return $this->questions;
    }

    public function setQuestions(string $questions): static
    {
        $this->questions = $questions;

        return $this;
    }
}
