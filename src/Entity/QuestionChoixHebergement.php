<?php

namespace App\Entity;

use App\Repository\QuestionChoixHebergementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionChoixHebergementRepository::class)]
class QuestionChoixHebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
