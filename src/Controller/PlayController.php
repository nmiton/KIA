<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Entity\AnimalType;
use App\Repository\AnimalRepository;
use App\Form\CreateAnimalType;
use App\Repository\ActionRepository;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\CaracteristicRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{
    #[Route('/preload', name: 'app_play_preload')]
    public function preload(UserRepository $repo): Response
    {
        if($this->getUser()){
            //si le user est verifié
            if(!$this->getUser()->isVerified()){
                return $this->render('registration/verify_my_email.html.twig');
            }else{
                //nb d'aimaux vivant(s) pr le user
                $animals=$repo->findAnimalIsAliveWithLifeByUserId($this->getUser()->getId());
                
                // dd($this->getUser()->getId());
                //si le user n'a pas d'animaux vivant
                if(count($animals)==0){
                    return $this->redirectToRoute('app_new_animal');
                }else{
                    return $this->render('play/choose_animal.html.twig', ['animal' => $animals]);
                }
            }
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/jouer/{id}', name: 'app_play', methods: ['GET'])]
    public function play(Animal $animal,AnimalCaracteristicRepository $statsRepo, ActionRepository $repoAction): Response
    {   
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            if($animal->getUser()->getId()!=$this->getUser()->getId() || !$animal->getIsAlive() ){
                return $this->redirectToRoute('app_play_preload');
            }else{
                $typesActionTypeAnimal = $repoAction->findTypeActionByAnimalType($animal->getAnimalType()->getId());
                // dd($typesActionTypeAnimal);
                $stats = $statsRepo->findAllStatsByAnimalId($animal->getId());
                return $this->render('play/main.html.twig', [
                    'animal' => $animal,
                    'stats' => $stats,
                    'typesAction' => $typesActionTypeAnimal,
                    'actions' => null
                ]);   
            }
        }
    }

    #[Route('/jouer/{id}/{typeAction}/' , name: 'app_play_type_action', methods : ['POST'])]
    public function selectTypeAction(Animal $animal, $typeAction,AnimalCaracteristicRepository $statsRepo, ActionRepository $repoAction):Response
    {   
        $stats = $statsRepo->findAllStatsByAnimalId($animal->getId());
        $typesActionTypeAnimal = $repoAction->findTypeActionByAnimalType($animal->getAnimalType()->getId());

        $actions_type_action_type_animal = $repoAction->findByActionsAnimalTypeAndActionTypeWhereObjectsInInventory($animal->getAnimalType()->getId(),$typeAction);
        $stats_actions_type_action_type_animal = $repoAction->findByStatsActionsByAnimalTypeAndActionType($animal->getAnimalType()->getId(),$typeAction);

        // dd($stats_actions_type_action_type_animal);
        return $this->render('play/main.html.twig', [
            'animal' => $animal,
            'stats' => $stats,
            'typesAction' => $typesActionTypeAnimal,
            'actions' => $actions_type_action_type_animal,
            'stats_actions' => $stats_actions_type_action_type_animal,
        ]);           
    }

    #[Route('/action/{id}' , name: 'app_play_action')]
    public function executeAction():Response
    {   
        return $this->render('play/main.html.twig');   
    }


    #[Route('/choisir-animal', name: 'app_choose_animal')]
    public function chooseAnimal(): Response
    {
        return $this->renderForm('play/choose_animal.html.twig');
    }


    #[Route('/creer-nouvel-animal', name: 'app_new_animal')]
    public function createNewAnimal(Request $request, AnimalRepository $animalRepository, CaracteristicRepository $statsRepo, AnimalCaracteristicRepository $statsAnimalRepo): Response
    {
        $animal = new Animal();
        $form = $this->createForm(CreateAnimalType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $today = new DateTime();
            $animal->setName($form->get('name')->getData());
            $animal->setAnimalType($form->get('animalType')->getData());
            $animal->setIsAlive(1);
            $animal->setCreatedAt($today);
            $animal->setLastActive($today);
            $animal->setUser($this->getUser());
            $animalRepository->add($animal);
            //on récupère nos entity stats
            $all_stats = $statsRepo->findAll();
            //on créer chq stats pr l'animal
            foreach ($all_stats as $stat) {
                dump($stat);
                $stats_animal = new AnimalCaracteristic();
                $stats_animal->setAnimal($animal);
                $stats_animal->setCaracteristic($stat);
                $stats_animal->setValue(100);
                $statsAnimalRepo->add($stats_animal);
            }
            return $this->redirectToRoute('app_play', ['id' => $animal->getId()]);
        }

        return $this->render('play/create_new_animal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}