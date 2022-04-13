<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalCaracteristic;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\AnimalRepository;
use App\Repository\CaracteristicRepository;
use Twig\Extension\AbstractExtension;
use DateTime;

class CreateNewAnimal extends AbstractExtension
{
    private AnimalRepository $animalRepository;   
    private CaracteristicRepository $statsRepo;
    private AnimalCaracteristicRepository $statsAnimalRepo;   

    
    public function __construct(AnimalRepository $animalRepository, CaracteristicRepository $statsRepo,AnimalCaracteristicRepository $statsAnimalRepo)
    {
        $this->animalRepository=$animalRepository;
        $this->statsRepo=$statsRepo;
        $this->statsAnimalRepo=$statsAnimalRepo;
    }

    public function createAnimal($form,$user): Animal
    {
        //initialisation du nouvel animal
        $animal = new Animal();
        //initialisation de la date du jour
        $today = new DateTime();
        //set des valeurs de l'animal
        $animal->setName($form->get('name')->getData());
        $animal->setAnimalType($form->get('animalType')->getData());
        $animal->setIsAlive(1);
        $animal->setCreatedAt($today);
        $animal->setLastActive($today);
        //ajout du propriétaire
        $animal->setUser($user);
        $this->animalRepository->add($animal);
        //on récupère nos entity stats
        $all_stats = $this->statsRepo->findAll();
        //on créer chq stats pr l'animal
        foreach ($all_stats as $stat) {
            $stats_animal = new AnimalCaracteristic();
            $stats_animal->setAnimal($animal);
            $stats_animal->setCaracteristic($stat);
            $stats_animal->setValue(100);
            $this->statsAnimalRepo->add($stats_animal);
        }
        return $animal;
    }


}
