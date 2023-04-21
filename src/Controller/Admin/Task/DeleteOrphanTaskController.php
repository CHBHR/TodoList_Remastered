<?php

namespace App\Controller\Admin\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteOrphanTaskController extends AbstractController
{
    #[Route('/admin/tasks/{id}/delete', name: 'admin_task_delete')]
    public function deleteTask(Task $task, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('admin_task_list');
    }
}
