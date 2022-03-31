<?php

namespace App\DataFixtures;

use App\Entity\ActionObjects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActionObjectsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //jouer balle de tennis
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('jouerBalleTennis'));
        $var->setObject($this->getReference('balle_tennis'));
        $manager->persist($var);      
        $this->addReference('actionObjectBalleTennis', $var);
        //nourrir croquettes
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('nourrirCroquette'));
        $var->setObject($this->getReference('croquettes'));
        $manager->persist($var);      
        $this->addReference('actionObjectCroquette', $var);
        //remplir gamelle
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('remplirGamelle'));
        $var->setObject($this->getReference('eau'));
        $manager->persist($var);      
        $this->addReference('actionObjectGamelle', $var);
        $manager->flush();
    }

    public function getOrder(){         
        return 11;     
    }
}
