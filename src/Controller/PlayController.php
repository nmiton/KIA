<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Repository\AnimalRepository;
use App\Form\CreateAnimalType;
use App\Repository\ActionCaracteristicRepository;
use App\Repository\ActionObjectsRepository;
use App\Repository\ActionRepository;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\CaracteristicRepository;
use App\Repository\InventoryRepository;
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
        //si un user est connecté
        if($this->getUser()){
            //si le user est verifié
            if(!$this->getUser()->isVerified()){
                return $this->render('registration/verify_my_email.html.twig');
            }else{
                //animaux de l'user
                $animals=$repo->findAnimalIsAliveWithLifeByUserId($this->getUser()->getId());
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
        //si user non conncté
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            //si l'animal (id dans URL) n'appartient pas au user actuel
            if($animal->getUser()->getId() != $this->getUser()->getId() || !$animal->getIsAlive() ){
                return $this->redirectToRoute('app_play_preload');
            }else{
                //affichage du tableau des animaux vivant du joueur
                $typesActionTypeAnimal = $repoAction->findTypeActionByAnimalType($animal->getAnimalType()->getId());
                //récupération des stats des animaux
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
        //récupération des stats de l'animal
        $stats = $statsRepo->findAllStatsByAnimalId($animal->getId());
        //récupération de tous les types d'action par type d'animaux
        $typesActionTypeAnimal = $repoAction->findTypeActionByAnimalType($animal->getAnimalType()->getId());
        //récupération des toutes les actions par type d'action et par type d'animaux
        $actions_type_action_type_animal = $repoAction->findByActionsAnimalTypeAndActionTypeWhereObjectsInInventory($animal->getAnimalType()->getId(),$typeAction);
        //récupération des stats de chaq action par type d'action et type d'animaux
        $stats_actions_type_action_type_animal = $repoAction->findByStatsActionsByAnimalTypeAndActionType($animal->getAnimalType()->getId(),$typeAction);

        return $this->render('play/main.html.twig', [
            'animal' => $animal,
            'stats' => $stats,
            'typesAction' => $typesActionTypeAnimal,
            'actions' => $actions_type_action_type_animal,
            'stats_actions' => $stats_actions_type_action_type_animal,
        ]);           
    }

    #[Route('/jouer/{id}/action/{idAction}/' , name: 'app_play_make_action', methods : ['POST'])]
    public function makeAction(
        Animal $animal,
        $idAction,
        ActionCaracteristicRepository $actionCaracRepo,
        AnimalCaracteristicRepository $animalCaracRepo,
        ActionObjectsRepository $actionObjetRepo,
        ActionRepository $actionRepo,
        InventoryRepository $inventoryRepo):Response
    {   
        $action = $actionRepo->findBy(
            array(
                'id' => $idAction,
            )
        );
        //Maj console 
        //on récupère le console log de l'action 
        $console = $action[0]->getConsoleLog();
        //récupération de tous les types d'action par type d'animaux
        $typesActionTypeAnimal = $actionRepo->findTypeActionByAnimalType($animal->getAnimalType()->getId());
        //gestion des stats de l'animal en fonction de l'action choisie
        //recuperation des stats de l'animal
        $stats = $animalCaracRepo->findAllStatsByAnimalId($animal->getId());
        //recupération des stats de l'action 
        $statsActionChoisie = $actionCaracRepo->findByIdAction($idAction);
        //pour chq stats de l'action
        foreach ($statsActionChoisie as $stat) {
            //si action boost 
            if($stat["val_max"] < $stat["val_min"]){
                $val_min_stats_action = $stat["val_max"];
                $val_max_stats_action = $stat["val_min"];
            }else{
                $val_min_stats_action = $stat["val_min"];
                $val_max_stats_action = $stat["val_max"];
            }
            //random sur la valeur de stat
            $random_value = random_int($val_min_stats_action,$val_max_stats_action);
            //récupération de la valeur de la stats de l'animal
            $valueStat = $animalCaracRepo->findByValueStatByStatIdAndAnimalId($stat["caracteritic_id"],$animal->getId())[0];
            //calcul nouvelle Stat
            $newStat = $valueStat["value"] + $random_value; 
            //condition 0<stats<100
            if($newStat>100){
                $newStat = 100;
            }elseif($newStat<0){
                $newStat = 0;
            }
            //récupération de l'entity stats animal correspondante a celle de l'action
            $statAnimal = $animalCaracRepo->findBy(
                array('id'=> $valueStat["id"])
            )[0];
            // set Animal stats
            $statAnimal->setValue($newStat);
            $statAnimal->getValue();
            $animalCaracRepo->add($statAnimal);
        }

        //Calcul de proba de perte de l'object utilisé pr l'action

        //on récupère la proba de l'objet lié à l'action
        $objet = $actionObjetRepo->findByActionIdLossPercentage($idAction);
        $proba = $objet[0]["loss_percentage"];
        $idObjet = $objet[0]["id"];
        //on génère un int random entre 0 et 100 
        $random_proba_perte = random_int(0, 100);
        // dump($random_proba_perte);
        //on regarde l'inventaire de l'utilisateur en fonction de l'objet de l'action sélectionné
        $inventory = $inventoryRepo ->findBy(
            array(
                'objet' => $idObjet,
                'user' => $this->getUser()->getId()
            )      
        );
        // si le random est inf a la proba de l'objet
        if($random_proba_perte<=$proba){
            $inventoryRepo->remove($inventory[0]);
        }

        
        //TODO
        //Maj lastActive User
        //TODO
        return $this->render('play/main.html.twig', [
            'animal' => $animal,
            'stats' => $stats,
            'console' => $console,
            'typesAction' => $typesActionTypeAnimal,
            'actions' => null,
            'stats_actions' => null,
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