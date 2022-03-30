<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Repository\AnimalRepository;
use App\Form\CreateAnimalType;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\CaracteristicRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class PlayController extends AbstractController
{
    #[Route('/preload', name: 'app_play_preload')]
    public function preload(UserRepository $repo, AnimalCaracteristicRepository $statsAnimalRepo): Response
    {
        if($this->getUser()){
            //si le user est verifié
            if(!$this->getUser()->isVerified()){
                return $this->render('registration/verify_my_email.html.twig');
            }else{
                //nb d'aimaux vivant(s) pr le user
                $animals =$repo->findAnimalIsAliveWithLifeByUserId($this->getUser()->getId());
                //si le user n'a pas d'animaux vivant
                // dd($animals);
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
    public function play(Animal $animal,UserRepository $repo,AnimalCaracteristicRepository $statsRepo): Response
    {   
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            if($animal->getUser()->getId()!=$this->getUser()->getId() || !$animal->getIsAlive() ){
                return $this->redirectToRoute('app_play_preload');
            }else{
                $stats = $statsRepo->findAllStatsByAnimalId($animal->getId());
                return $this->render('play/main.html.twig', ['animal' => $animal,'stats' => $stats ]);   
            }
        }
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