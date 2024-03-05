<?php

namespace App\DTO;

class QuizChoicesDTO
{
    /**
     * @var array<int, array<int>>
     */
    private array $selectedAnswers = [];

    public function getSelectedAnswers(): array
    {
        return $this->selectedAnswers;
    }

    public function setSelectedAnswers(int $questionId, array $answerIds): void
    {
        $this->selectedAnswers[$questionId] = $answerIds;
    }

    public function fromRequest(array $requestValues): ?QuizChoicesDTO
    {
        $quizChoices = $requestValues['questions'] ?? null;

        if (!$quizChoices) {
            return null;
        }

        $quizChoicesDTO = new QuizChoicesDTO();

        /** @var array<int, string> $quizChoice */
        foreach ($quizChoices as $key => $quizChoice) {

            $selectedKeys = array_keys(array_filter($quizChoice, function ($value) {
                return $value === "1";
            }));

            $quizChoicesDTO->setSelectedAnswers($key, $selectedKeys);
        }

        return $quizChoicesDTO;
    }
}