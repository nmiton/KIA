<?php

namespace App\Service;

use App\Entity\Animal;
use App\Repository\AnimalCaracteristicRepository;
use Twig\Extension\AbstractExtension;
use DateTime;

class UpdateCaracteristicAction extends AbstractExtension
{
    private AnimalCaracteristicRepository $animalCaracRepo;   
    
    public function __construct(AnimalCaracteristicRepository $animalCaracRepo)
    {
        $this->animalCaracRepo=$animalCaracRepo;
    }

    public function setCaractAnimalWithStatsSelectedAction($statsSelectedAction,$valueStatAnimal)
    {
        //pour chq stats de l'action
        foreach ($statsSelectedAction as $stat) {
            //si action caracts boost 
            if($stat->getValMax() < $stat->getValMin()){
                $val_min_stats_action = $stat->getValMax();
                $val_max_stats_action = $stat->getValMin();
            }else{
                $val_min_stats_action = $stat->getValMin();
                $val_max_stats_action = $stat->getValMax();
            }
            //random sur la valeur de stat
            $random_value = random_int($val_min_stats_action,$val_max_stats_action);
            foreach ($valueStatAnimal as $var ) {
                if($var->getCaracteristic()->getId() == $stat->getCaracteritic()->getId()){
                    // calcul nouvelle Stat
                    $newStat = $var->getValue() + $random_value; 
                    // condition 0<stats<100
                    if($newStat>100){
                        $newStat = 100;
                    }elseif($newStat<0){
                        $newStat = 0;
                    }
                    //récupération de l'entity stats animal correspondante a celle de l'action
                    $statAnimal = $this->animalCaracRepo->findOneBy(
                        array('id'=> $var->getId())
                    );
                    //MAJ Animal stats
                    $statAnimal->setValue($newStat);
                    $statAnimal->getValue();
                    $this->animalCaracRepo->add($statAnimal);
                }
            }
        }
    }


}
