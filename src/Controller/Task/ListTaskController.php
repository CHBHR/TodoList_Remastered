<?php

namespace App\Controller\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks/list', name: 'task_list')]
class ListTaskController extends AbstractController
{
    public function listTasks(EntityManagerInterface $entityManager)
    {
    }
}