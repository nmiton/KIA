<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $msg_paye = isset($_GET['msg_paye']) ? $_GET['msg_paye'] : null;

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'msg_paye'=>$msg_paye,
        ]);
    }
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('home/mentions_legales.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/presentation-equipe', name: 'app_presentation_equipe')]
    public function presentationEquipe(): Response
    {
        return $this->render('home/presentation_equipe.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/regles-du-jeu', name: 'app_regles-du-jeu')]
    public function reglesDuJeu(): Response
    {
        return $this->render('home/regles_jeu.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
