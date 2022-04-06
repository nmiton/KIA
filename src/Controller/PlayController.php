<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Entity\Caracteristic;
use App\Repository\AnimalRepository;
use App\Form\CreateAnimalType;
use App\Repository\ActionCaracteristicRepository;
use App\Repository\ActionObjectsRepository;
use App\Repository\ActionRepository;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\CaracteristicRepository;
use App\Repository\InventoryRepository;
use App\Repository\UserRepository;
use App\Service\PayDay;
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

                $payDay = new PayDay();
                $payDay->jourDePaye($this->getUser(), $repo);

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
                    'actions' => null,
                    'msg_danger' => null,
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
            'msg_danger' => null,
        ]);           
    }

    #[Route('/jouer/{id}/action/{idAction}/' , name: 'app_play_make_action', methods : ['POST'])]
    public function makeAction(
        Animal $animal,
        $idAction,
        ActionCaracteristicRepository $actionCaracRepo,
        AnimalCaracteristicRepository $animalCaracRepo,
        ActionObjectsRepository $actionObjetRepo,
        CaracteristicRepository $caracRepo,
        ActionRepository $actionRepo,
        InventoryRepository $inventoryRepo,
        UserRepository $userRepo):Response
    {   
        $action = $actionRepo->find(['id' => $idAction]);
        
        //stats d avant action 
        $stats = $animalCaracRepo->findAllStatsByAnimalId($animal->getId());
        $objetPerdu = null;
        //Maj console 

        //on récupère le console log de l'action 
        $console = $action->getConsoleLog();
        //récupération de tous les types d'action par type d'animaux
        $typesActionTypeAnimal = $actionRepo->findTypeActionByAnimalType($animal->getAnimalType()->getId());


        //on récupère l'entity nourriture
        $entity_stat_nourriture = $caracRepo->findOneBy(['name'=> "Nourriture"]);
        //on récupère l'entity énergie
        $entity_stat_energie = $caracRepo->findOneBy(['name'=> "Énergie"]);
        //on récupère l'entity hydratation
        $entity_stat_eau = $caracRepo->findOneBy(['name'=> "Hydratation"]);
        //on cherche l'hydratation de l'animal
        $stat_eau_animal = $animalCaracRepo->findOneBy(["animal" => $animal, "caracteristic" => $entity_stat_eau ]);
        //on cherche la nourriture de l'animal
        $stat_nouriture_animal = $animalCaracRepo->findOneBy(["animal" => $animal, "caracteristic" => $entity_stat_nourriture ]);
        //on cherche l'energie de l'animal
        $stat_energie_animal = $animalCaracRepo->findOneBy(["caracteristic"=> $entity_stat_energie, "animal"=> $animal ]);

        if($action->getType() == "Jouer" || $action->getType() == "Sortir"){
            // dd($stat_energie_animal);
            //erreur si énergie est <= 10 (pas de promenade, ni de jeu) 
            if($stat_energie_animal->getValue()<=10){
                return $this->render('play/main.html.twig', [
                'animal' => $animal,
                'stats' => $stats,
                'typesAction' => $typesActionTypeAnimal,
                'actions' => null,
                'msg_danger' => "Attention l'énergie de votre animal est trop faible 
                                    pour pouvoir : ".$action->getName().". Veuillez 
                                    faire le nécessaire afin d'augmenter 
                                    cette statistique!",
                ]); 
            }
        }
        
        //gestion des stats de l'animal en fonction de l'action choisie
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

        //Calcul de l'énergie
        //on gère ici l'énergie de l'animal après avoir gérer les stats qui ont été affectées par l'action choisie        
        //on cherche la nouvelle valeur d'hydratation de l'animal
        $stat_eau_animal = $animalCaracRepo->findOneBy(["animal" => $animal, "caracteristic" => $entity_stat_eau ]);
        //on cherche la nouvelle valeur de la nourriture de l'animal
        $stat_nouriture_animal = $animalCaracRepo->findOneBy(["animal" => $animal, "caracteristic" => $entity_stat_nourriture ]);
        //on set la nouvelle valeur de energie avec (nourriture+hydaration)/2 
        $stat_energie_animal->setValue(($stat_nouriture_animal->getValue()+$stat_eau_animal->getValue())/2);
        //on persite dans la bdd
        $animalCaracRepo->add($stat_energie_animal);

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
            if($proba < 100){
                $objetPerdu = "Vous venez de perdre votre ".$objet[0]["name"].".";
            }
        }

        //recuperation des stats de l'animal
        $stats = $animalCaracRepo->findAllStatsByAnimalId($animal->getId());
    
        //Maj lastActive User
        $dateTime = new DateTime();
        $user= $this->getUser();
        $user->setLastActive($dateTime);
        $userRepo->add($user);
        
        return $this->render('play/main.html.twig', [
            'animal' => $animal,
            'stats' => $stats,
            'console' => $console,
            'typesAction' => $typesActionTypeAnimal,
            'actions' => null,
            'stats_actions' => null,
            'msg_danger' => $objetPerdu,
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
