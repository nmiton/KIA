<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function classementParType(): Response
    {
        return $this->render('leaderboard/leaderboardByType.html.twig', [
            'controller_name' => 'LeaderboardController',
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
