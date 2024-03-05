<?php

namespace App\Services;

use App\DTO\QuizAnswersDTO;
use App\DTO\QuizChoicesDTO;
use App\DTO\ResultQuizDTO;
use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;

class CalculateQuizResultService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculate(QuizChoicesDTO $quizChoicesDTO, array $questions): ResultQuizDTO
    {
        $quizAnswersDTO = $this->getQuizAnswers();

        $resultQuizDTO = new ResultQuizDTO();

        foreach ($questions as $question) {
            $userSelectedAnswerIds = $quizChoicesDTO->getSelectedAnswers()[$question->getId()] ?? null;
            $wrongAnswerIds = $quizAnswersDTO->getWrongAnswerIds()[$question->getId()] ?? null;
            $rightAnswerIds = $quizAnswersDTO->getRightAnswerIds()[$question->getId()] ?? null;

            $containsWrongAnswer = array_intersect($userSelectedAnswerIds, $wrongAnswerIds);
            $containsRightAnswer = array_intersect($userSelectedAnswerIds, $rightAnswerIds);

            if (!$containsWrongAnswer && $containsRightAnswer) {
                $resultQuizDTO->setRightAnsweredQuestions($question);
            } else {
                $resultQuizDTO->setWrongAnsweredQuestions($question);
            }
        }

        return $resultQuizDTO;
    }

    private function getQuizAnswers(): QuizAnswersDTO
    {
        /** @var Answer[] $answers */
        $answers = $this->entityManager->getRepository(Answer::class)->findAll();

        $quizAnswersDTO = new QuizAnswersDTO();

        foreach ($answers as $answer) {
            $questionId = $answer->getQuestion()->getId();
            $answerId = $answer->getId();
            $answer->isCorrect() ? $quizAnswersDTO->setRightAnswerId($questionId, $answerId) : $quizAnswersDTO->setWrongAnswerId($questionId, $answerId);
        }

        return $quizAnswersDTO;
    }
}