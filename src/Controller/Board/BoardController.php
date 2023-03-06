<?php

namespace App\Controller\Board;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    #[Route('/board', name: 'task_board')]
    public function showBoard(EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $taskList = $entityManager->getRepository(Task::class)->findOpenTasksByUser($user);
        return $this->render('board/board.html.twig', [
            'tasks' => $taskList
        ]);
    }
}
