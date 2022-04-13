<?php

namespace App\Controller;

use App\Form\SelectTypeAnimalType;
use App\Repository\UserRepository;
use App\Repository\ScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/classement')]
class LeaderboardController extends AbstractController
{

    #[Route('/', name: 'app_leaderboard')]
    public function index(): Response
    {
        return $this->render('leaderboard/index.html.twig', [
            'controller_name' => 'LeaderboardController'
        ]);
    }

    #[Route('/classement-par-types', name: 'app_leaderboard_by_types')]
    public function classementParType(Request $request, ScoreRepository $repo): Response
    {   
        $classement = null;
        $form = $this->createForm(SelectTypeAnimalType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $animalType = $form->get("animalType")->getData();
            // dd($form->get("animalType")->getData()->getId());
            $id_type_animal = $form->get("animalType")->getData()->getId();
            $classement = $repo->findAllScoresByAnimalTypeId($id_type_animal);
            // dd($classement);
            return $this->render('leaderboard/leaderboardByType.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'LeaderboardController',
                'classement' => $classement,
                'animalType' => $animalType
            ]);
        }
        return $this->render('leaderboard/leaderboardByType.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'LeaderboardController',
            'classement' => $classement,
        ]);
    }

    #[Route('/classement-général', name: 'app_leaderboard_by_players')]
    public function classmentGeneral(UserRepository $userRepository): Response
    {
        $users=$userRepository->findAllUserByScoreDesc();
        return $this->render('leaderboard/leaderboardAllPlayers.html.twig', [
            'controller_name' => 'LeaderboardController',
            'users'=>$users
        ]);
    }
}
