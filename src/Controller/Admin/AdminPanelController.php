<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_pannel")
     */
    public function index(): Response
    {
        return $this->render('Admin/AdminPannel.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }
}
