<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListUserController extends AbstractController
{
    #[Route('/admin/users/list', name: 'admin_user_list')]
    public function listUser(EntityManagerInterface $entityManager)
    {
        return $this->render(
            'admin/user/list.html.twig',
            ['users' => $entityManager->getRepository(User::class)->findAll()]
        );
    }

}
