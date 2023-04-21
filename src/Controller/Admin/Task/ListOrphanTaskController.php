<?php

namespace App\Controller\Admin\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListOrphanTaskController extends AbstractController
{
    #[Route('/admin/task/list', name: 'admin_task_list')]
    public function showOrphanTaskList(EntityManagerInterface $entityManager)
    {
        $taskList = $entityManager->getRepository(Task::class)->findOrphantTasks();

        return $this->render('admin/task/list.html.twig', [
            'tasks' => $taskList,
        ]);
    }
}
