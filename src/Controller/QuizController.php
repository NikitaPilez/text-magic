<?php

namespace App\Controller;

use App\DTO\QuizChoicesDTO;
use App\Entity\Question;
use App\Services\CalculateQuizResultService;
use App\Services\SaveQuizResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'quiz_page')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $questions = $entityManager->getRepository(Question::class)->findAll();
        shuffle($questions);

        return $this->render('quiz/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/submit-answers', name: 'submit_answers', methods: ['POST'])]
    public function submitAnswers(
        Request                    $request,
        CalculateQuizResultService $calculateQuizResult,
        SaveQuizResult             $saveQuizResult,
        EntityManagerInterface     $entityManager,
        QuizChoicesDTO             $quizChoicesDTO): Response
    {
        /** @var QuizChoicesDTO $quizChoicesDTO */
        $quizChoicesDTO = $quizChoicesDTO->fromRequest($request->request->all());
        $questions = $entityManager->getRepository(Question::class)->findAll();

        $resultQuizDTO = $calculateQuizResult->calculate($quizChoicesDTO, $questions);

        $saveQuizResult->save($resultQuizDTO);

        return $this->render('quiz/result.html.twig', [
            'rightAnsweredQuestions' => $resultQuizDTO->getRightAnsweredQuestions(),
            'wrongAnsweredQuestions' => $resultQuizDTO->getWrongAnsweredQuestions(),
            'questions' => $questions,
        ]);
    }
}
