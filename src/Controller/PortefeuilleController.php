<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PortefeuilleController extends AbstractController
{
    #[Route('/portefeuille', name: 'app_portefeuille')]
    public function index(): Response
    {
        return $this->render('portefeuille/index.html.twig', [
            'controller_name' => 'PortefeuilleController',
        ]);
    }
}
