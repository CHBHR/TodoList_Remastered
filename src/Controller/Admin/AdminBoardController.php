<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBoardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function showDashboard()
    {
        return $this->render('admin/adminDashboard.html.twig');
    }
}
