<?php

namespace App\DataFixtures;

use App\Entity\ActionCaracteristic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActionCaracteristicFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        //Action sortir Parc chien
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+10);
        $var->setAction($this->getReference('sortirParcChien'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-25);
        $var->setAction($this->getReference('sortirParcChien'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-20);
        $var->setAction($this->getReference('sortirParcChien'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        //action jouer balle de tennis
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('jouerBalleTennisChien'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('jouerBalleTennisChien'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(+15);
        $var->setValMin(+10);
        $var->setAction($this->getReference('jouerBalleTennisChien'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        //action nourrir croquettes
        $var = new ActionCaracteristic();
        $var->setValMax(+15);
        $var->setValMin(+5);
        $var->setAction($this->getReference('nourrirCroquetteChien'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('nourrirCroquetteChien'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        //action remplir gamelle
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('remplirGamelleChien'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        //action soin niv 1
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('soinNiv1Chien'));
        $var->setCaracteritic($this->getReference('Vie'));
        $manager->persist($var);      
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('donnerFriandiseChien'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('donnerFriandiseChien'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      

        //Action sortir dragon
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+10);
        $var->setAction($this->getReference('actionSortirParcDragon'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-25);
        $var->setAction($this->getReference('actionSortirParcDragon'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-20);
        $var->setAction($this->getReference('actionSortirParcDragon'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        //action jouer balle de tennis
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('jouerBalleTennisDragon'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('jouerBalleTennisDragon'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(+15);
        $var->setValMin(+10);
        $var->setAction($this->getReference('jouerBalleTennisDragon'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        //action nourrir croquettes
        $var = new ActionCaracteristic();
        $var->setValMax(+15);
        $var->setValMin(+5);
        $var->setAction($this->getReference('nourrirCroquetteDragon'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('nourrirCroquetteDragon'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        //action remplir gamelle
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('remplirGamelleDragon'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        //action soin niv 1
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('soinNiv1Dragon'));
        $var->setCaracteritic($this->getReference('Vie'));
        $manager->persist($var);      
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(+25);
        $var->setValMin(+15);
        $var->setAction($this->getReference('donnerFriandiseDragon'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('donnerFriandiseDragon'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);   

        // //action type NOurrir
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(-5+$i);
        //     $var->setValMin(-15+$i);
        //     $var->setAction($this->getReference("ActionNourrir".$i));
        //     $var->setCaracteritic($this->getReference('Hydratation'));
        //     $manager->persist($var);      
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(+21+$i);
        //     $var->setValMin(+7+$i);
        //     $var->setAction($this->getReference("ActionNourrir".$i));
        //     $var->setCaracteritic($this->getReference('Nourriture'));
        //     $manager->persist($var);      
        // }
        // //action type soin
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(+20+$i);
        //     $var->setValMin(+15+$i);
        //     $var->setAction($this->getReference("ActionSoin".$i));
        //     $var->setCaracteritic($this->getReference('Vie'));
        //     $manager->persist($var);     
        // }
        // //action type Jouer
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(-5+$i);
        //     $var->setValMin(-15+$i);
        //     $var->setAction($this->getReference("ActionJouer".$i));
        //     $var->setCaracteritic($this->getReference('Hydratation'));
        //     $manager->persist($var);      
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(-7+$i);
        //     $var->setValMin(-21+$i);
        //     $var->setAction($this->getReference("ActionJouer".$i));
        //     $var->setCaracteritic($this->getReference('Nourriture'));
        //     $manager->persist($var);      
        // }
        // //action type Sortir
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(-7+$i);
        //     $var->setValMin(-21+$i);
        //     $var->setAction($this->getReference("ActionSortir".$i));
        //     $var->setCaracteritic($this->getReference('Nourriture'));
        //     $manager->persist($var);      
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(-5+$i);
        //     $var->setValMin(-15+$i);
        //     $var->setAction($this->getReference("ActionSortir".$i));
        //     $var->setCaracteritic($this->getReference('Hydratation'));
        //     $manager->persist($var);      
        // }
        // //action type boire
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionCaracteristic();
        //     $var->setValMax(+15+$i);
        //     $var->setValMin(+5+$i);
        //     $var->setAction($this->getReference("ActionBoire".$i));
        //     $var->setCaracteritic($this->getReference('Hydratation'));
        //     $manager->persist($var);      
        // }






        $manager->flush();
    }

    public function getOrder(){         
        return 10;     
    }
}
