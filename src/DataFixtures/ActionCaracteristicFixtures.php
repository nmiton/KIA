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

        //Action sortir Parc
        $var = new ActionCaracteristic();
        $var->setValMax(+5);
        $var->setValMin(+20);
        $var->setAction($this->getReference('actionSortirParc'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicBonheurSortirParc', $var);
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-25);
        $var->setAction($this->getReference('actionSortirParc'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicHydratationSortirParc', $var);
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-20);
        $var->setAction($this->getReference('actionSortirParc'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicNourritureSortirParc', $var);
        //action jouer balle de tennis
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('jouerBalleTennis'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicNourritureJouerBalleTennis', $var);
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('jouerBalleTennis'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicHydratationJouerBalleTennis', $var);
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('jouerBalleTennis'));
        $var->setCaracteritic($this->getReference('Bonheur'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicBonheurJouerBalleTennis', $var);
        //action nourrir croquettes
        $var = new ActionCaracteristic();
        $var->setValMax(+5);
        $var->setValMin(+15);
        $var->setAction($this->getReference('nourrirCroquette'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicNourritureNourrirCroquette', $var);
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-10);
        $var->setAction($this->getReference('nourrirCroquette'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicHydratationNourrirCroquette', $var);
        //action remplir gamelle
        $var = new ActionCaracteristic();
        $var->setValMax(+5);
        $var->setValMin(+25);
        $var->setAction($this->getReference('remplirGamelle'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicHydratationRemplirGamelle', $var);
        //action soin niv 1
        $var = new ActionCaracteristic();
        $var->setValMax(+5);
        $var->setValMin(+25);
        $var->setAction($this->getReference('soinNiv1'));
        $var->setCaracteritic($this->getReference('Vie'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicVieSoinNiveau1', $var);
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(+5);
        $var->setValMin(+25);
        $var->setAction($this->getReference('donnerFriandise'));
        $var->setCaracteritic($this->getReference('Nourriture'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicNourritureDonnerFriandise', $var);
        //action donner friandise
        $var = new ActionCaracteristic();
        $var->setValMax(-5);
        $var->setValMin(-15);
        $var->setAction($this->getReference('donnerFriandise'));
        $var->setCaracteritic($this->getReference('Hydratation'));
        $manager->persist($var);      
        $this->addReference('actionCaracteristicHydratationDonnerFriandise', $var);











        $manager->flush();
    }

    public function getOrder(){         
        return 10;     
    }
}
