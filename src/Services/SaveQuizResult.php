<?php

namespace App\Services;

use App\DTO\ResultQuizDTO;
use App\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;

class SaveQuizResult
{
    private EntityManagerInterface $entityManager;
    private GenerateNewQuizService $generateNewQuizService;

    public function __construct(EntityManagerInterface $entityManager, GenerateNewQuizService $generateNewQuizService,)
    {
        $this->entityManager = $entityManager;
        $this->generateNewQuizService = $generateNewQuizService;
    }

    public function save(ResultQuizDTO $resultQuizDTO): void
    {
        $quiz = $this->generateNewQuizService->generate();

        foreach ($resultQuizDTO->getWrongAnsweredQuestions() as $question) {
            $result = new Result();
            $result->setQuiz($quiz);
            $result->setQuestion($question);
            $result->setCorrect(false);

            $this->entityManager->persist($result);
        }

        foreach ($resultQuizDTO->getRightAnsweredQuestions() as $question) {
            $result = new Result();
            $result->setQuiz($quiz);
            $result->setQuestion($question);
            $result->setCorrect(true);

            $this->entityManager->persist($result);
        }

        $this->entityManager->flush();
    }
}