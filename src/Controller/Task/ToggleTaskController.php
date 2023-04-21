<?php

namespace App\Controller\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ToggleTaskController extends AbstractController
{
    #[Route('/tasks/{id}/toggle', name: 'task_toggle_isDone')]
    public function toggleTaskAction(Task $task, EntityManagerInterface $entityManager)
    {
        $task->isIsDone() ? $task->setIsDone(false) : $task->setIsDone(true);
        $entityManager->flush();

        $task->isIsDone() ?
            $this->addFlash('success', sprintf('La tâche "%s" a bien été marquée comme faite.', $task->getTitle())) :
            $this->addFlash('success', sprintf('La tâche "%s" a bien été remise sur votre tableau.', $task->getTitle()));

        return $this->redirectToRoute('task_board');
    }
}
