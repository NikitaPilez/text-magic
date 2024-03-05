<?php

namespace App\DTO;

use App\Entity\Question;

class ResultQuizDTO
{
    /**
     * @var array<Question>
     */
    private array $rightAnsweredQuestions = [];

    /**
     * @var array<Question>
     */
    private array $wrongAnsweredQuestions = [];

    public function getRightAnsweredQuestions(): array
    {
        return $this->rightAnsweredQuestions;
    }

    public function setRightAnsweredQuestions(Question $question): void
    {
        $this->rightAnsweredQuestions[] = $question;
    }

    public function getWrongAnsweredQuestions(): array
    {
        return $this->wrongAnsweredQuestions;
    }

    public function setWrongAnsweredQuestions(Question $question): void
    {
        $this->wrongAnsweredQuestions[] = $question;
    }
}