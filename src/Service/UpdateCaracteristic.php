<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\User;
use App\Entity\AnimalCaracteristic;
use App\Repository\AnimalCaracteristicRepository;
use App\Repository\AnimalRepository;
use App\Repository\AnimalTypeRepository;
use App\Repository\ScoreRepository;
use App\Repository\UserRepository;
use Twig\Extension\AbstractExtension;
use DateTime;

class UpdateCaracteristic extends AbstractExtension
{
    private AnimalCaracteristicRepository $repo;
    private AnimalRepository $animalRepo;
    private AnimalTypeRepository $atr;
    private UserRepository $ur;
    private ScoreRepository $sr;

    public function __construct(AnimalCaracteristicRepository $acR, AnimalRepository $aR, AnimalTypeRepository $atR, UserRepository $uR, ScoreRepository $sR)
    {
        $this->repo = $acR;
        $this->animalRepo = $aR;
        $this->atr = $atR;
        $this->ur = $uR;
        $this->sr = $sR;
    }

    public function setLastActiveAnimal(Animal $animal)
    {
        $animal->setLastActive(new DateTime());
        $this->animalRepo->add($animal);
    }

    public function updateCaract(User $user)
    {
        $tabReturn = [];

        $animalStats = $this->repo->findByAnimalStatsIsAliveWithUserId($user->getId());
        //dd($animalStats);
        $datetime = new DateTime();
        $interval = $user->getLastActive()->diff($datetime);
        //dd($interval);
        //calcul du nombre d'heure depuis la derniere activité
        $nbHours = $interval->h + $interval->d * 24 + $interval->m * 24 * 29 + $interval->y * 24 * 365;
        //dd($nbHours);
        // si il y a plus d'une heure depuis la derniere activité
        if ($nbHours > 0) {
            // pour chaque heure faire :
            for ($i = 1; $i <= $nbHours; $i++) {
                //dd($animalStats[0]["value"]);
                // si une des stats "vitale" est a 0 alors :
                if ($animalStats[1]["value"] == 0 || $animalStats[2]["value"] == 0 || $animalStats[4]["value"] == 0) {
                    // update stats vie
                    if ($animalStats[0]["lost_by_hour"] > $animalStats[0]["value"]) {
                        $animalStats[0]["value"] = 0;
                        $animal = $this->animalRepo->find($animalStats[0]["animal_id"]);
                        $animal->setIsAlive(false);
                        $this->animalRepo->add($animal);

                        //donne les animaux mort nom et type
                        array_push($tabReturn, [
                            "name" => $animal->getName(),
                            "type" => $this->atr->find($animal->getAnimalType())->getName()
                        ]);
                        break;
                        //setScore et is alive false
                    } else {
                        $animalStats[0]["value"] -= $animalStats[0]["lost_by_hour"];
                    }
                }
                // pour toutes les autres stats
                for ($j = 1; $j <= 4; $j++) {
                    //update stats
                    if ($animalStats[$j]["value"] > 0) {
                        if ($animalStats[$j]["lost_by_hour"] > $animalStats[$j]["value"]) {
                            $animalStats[$j]["value"] = 0;
                        } else {
                            $animalStats[$j]["value"] -= $animalStats[$j]["lost_by_hour"];
                        }
                        //dd($animalStats[1]["value"]);

                    }
                }
            }
            //dd($animalStats);
            // calcul energie
            $animalStats[3]["value"] = ($animalStats[1]["value"] + $animalStats[2]["value"]) / 2;
            // MAJ valeur dans la BDD
            for ($i = 0; $i <= 4; $i++) {
                $caract = new AnimalCaracteristic;
                $caract = $this->repo->find($animalStats[$i]["id"]);
                $caract->setValue($animalStats[$i]["value"]);
                $this->repo->add($caract);
            }
        }

        $user->setLastActive(new DateTime());
        $this->ur->add($user);
        return $tabReturn;
    }
}
