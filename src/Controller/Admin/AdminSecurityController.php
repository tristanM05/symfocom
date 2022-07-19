<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecurityController extends AbstractController
{
    /**
     * @Route("/admin/log", name="admin_log")
     */
    public function index(AuthenticationUtils $outils): Response
    {
        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();
        return $this->render('Admin/admin_security/connexionAdmin.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant,
        ]);
    }
}
