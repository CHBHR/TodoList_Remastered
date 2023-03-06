<?php

namespace App\Controller\Board;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DoneBoardController extends AbstractController
{
    #[Route('/board/done', name: 'task_done_board')]
    public function showDoneBoard(EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $taskList = $entityManager->getRepository(Task::class)->findDoneTasksByUser($user);
        return $this->render('board/doneBoard.html.twig', [
            'tasks' => $taskList
        ]);
    }
}
