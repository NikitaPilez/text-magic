<?php

namespace App\DTO;

class QuizAnswersDTO
{
    /**
     * @var array<int, array<int>>
     */
    private array $rightAnswerIds = [];

    /**
     * @var array<int, array<int>>
     */
    private array $wrongAnswerIds = [];

    public function getRightAnswerIds(): array
    {
        return $this->rightAnswerIds;
    }

    public function setRightAnswerId(int $questionId, int $answerId): void
    {
        $this->rightAnswerIds[$questionId][] = $answerId;
    }

    public function getWrongAnswerIds(): array
    {
        return $this->wrongAnswerIds;
    }

    public function setWrongAnswerId(int $questionId, int $answerId): void
    {
        $this->wrongAnswerIds[$questionId][] = $answerId;
    }
}