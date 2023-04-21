<?php

namespace App\Controller\Task;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateTaskController extends AbstractController
{
    /**
     * Créer une task lié à l'utilisateur
     * Si aucun utilisateur, la task sera liée à NULL.
     */
    #[Route('/tasks/create', name: 'task_create')]
    public function createTask(Request $request, EntityManagerInterface $entityManager)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateTime = new \DateTime();
            // On récupère le user et on l'assigne à la task avant le persist
            $user = $this->getUser();
            if (false === $user) {
                $task->setuser(null);
            } else {
                $task->setUser($user);
            }

            // Check si une deadline a été précisée sinon null
            if (true === $form['hasDeadLine']->getData()) {
                $task->setDeadLine($form['deadLine']->getData());
            } elseif (false === $form['hasDeadLine']->getData()) {
                $task->setDeadLine(null);
            }
            $task->setCreatedAt($dateTime);
            $task->setIsDone(false);

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_board');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
