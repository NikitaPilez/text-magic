<?php

namespace App\Services;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;

class GenerateNewQuizService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate(): Quiz
    {
        $quiz = new Quiz();
        $this->entityManager->persist($quiz);
        $this->entityManager->flush();

        return $quiz;
    }
}