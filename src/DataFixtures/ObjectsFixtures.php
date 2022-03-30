<?php

namespace App\DataFixtures;

use App\Entity\Objects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ObjectsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $objet = new Objects();
        $objet->setName("Balle de tennis");
        $objet->setPrice(15);
        $objet->setLossPercentage(80);
        $manager->persist($objet);        
        $this->addReference('objet1', $objet);
        $manager->flush();
    }

    public function getOrder(){         
        return 7;     
    }
}
