<?php

namespace App\Controller\Admin\User;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/users/{id}/delete', name: 'admin_user_delete')]
    public function deleteUser(User $user)
    {
        $this->anonymiseTasks($user);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'L\' utilisateur à bien été supprimer');

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * Supprime l'id de la tache liée à l'utilisateur et met NULL.
     */
    public function anonymiseTasks($user)
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findTasksByUser($user);
        foreach ($tasks as $task) {
            $task->setuser(null);
            $this->entityManager->flush();
        }
    }
}
