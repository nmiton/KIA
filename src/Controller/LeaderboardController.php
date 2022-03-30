<?php

namespace App\Controller;
use App\Entity\AnimalType;
use App\Form\SelectTypeAnimalType;
use App\Repository\UserRepository;
use App\Repository\ScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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

    #[Route('/classement-par-types', name: 'app_leaderboard_by_types', methods: ['POST'])]
    public function classementParType(Request $request, ScoreRepository $repo): Response
    {
        $classement = null;
        $animalType = new AnimalType();
        $form = $this->createForm(SelectTypeAnimalType::class);
        
        if ($request->isMethod('POST')) {
            // if ($form->isSubmitted() && $form->isValid()) {
                dd($request->request->get($form->getName()));
                $classement = $repo->findScoresByAnimalTypeId($animalType->getId());
            // }
            // dd($request);
        }
        // $form->handleRequest($request);
        
        
        
        
        return $this->render('leaderboard/leaderboardByType.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'LeaderboardController',
            'classement' => $classement,
            'animalType' => $animalType
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
