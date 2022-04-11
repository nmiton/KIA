<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Entity\User;
use App\Form\CreateAnimalType;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\AnimalRepository;
use App\Repository\AnimalTypeRepository;
use App\Repository\CaracteristicRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\UpdateCaracteristic;

class PreloadController extends AbstractController
{

    #[Route('/preload', name: 'app_play_preload')]
    public function preload(UserRepository $repoUser, AnimalCaracteristicRepository $repo, UpdateCaracteristic $updateCaracteristic, AnimalRepository $animalRepo, AnimalTypeRepository $repoAnimalType): Response
    {
        //si un user est connecté
        if ($this->getUser()) {
            //si le user est verifié
            if (!$this->getUser()->isVerified()) {
                return $this->render('registration/verify_my_email.html.twig');
            } else {
                //MAJ STATS
                // TODO AFFICHER "TON ANIMAL A CREVÉ"
                $animalsMorts = $updateCaracteristic->updateCaract($this->getUser(), $repo, $animalRepo, $repoAnimalType, $repoUser);
                //animaux de l'user
                $animals = $repoUser->findAnimalIsAliveWithLifeByUserId($this->getUser()->getId());

                //si le user n'a pas d'animaux vivant
                if (count($animals) == 0) {
                    return $this->redirectToRoute('app_new_animal');
                } else {
                    return $this->render('play/choose_animal.html.twig', [
                        'animal' => $animals,
                        'animalsMorts' => $animalsMorts
                    ]);
                }
            }
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/choisir-animal', name: 'app_choose_animal')]
    public function chooseAnimal(): Response
    {
        return $this->renderForm('play/choose_animal.html.twig');
    }


    #[Route('/creer-nouvel-animal', name: 'app_new_animal')]
    public function createNewAnimal(Request $request, AnimalRepository $animalRepository, CaracteristicRepository $statsRepo, AnimalCaracteristicRepository $statsAnimalRepo, AnimalTypeRepository $atr): Response
    {
        $animal = new Animal();
        $form = $this->createForm(CreateAnimalType::class);
        $form->handleRequest($request);

        $animalsMorts = $animalRepository->findAllDeadAnimalsByUser($this->getUser()->getId(), $atr);

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
            'animalsMorts' => $animalsMorts
        ]);
    }
}
