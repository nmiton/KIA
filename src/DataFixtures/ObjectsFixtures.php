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
        $objet->setDescription("Balle jaune pour jouer à la raquette");
        $objet->setLossPercentage(30);
        $manager->persist($objet);
        $this->addReference('balle_tennis', $objet);

        for ($i=1; $i < 6 ; $i++) { 
            $objet = new Objects();
            $objet->setName('objet'.$i);
            $objet->setDescription("desc_objet".$i);
            $objet->setPrice(10);
            $objet->setLossPercentage(50);
            $manager->persist($objet);         
            $this->addReference('objet'.$i, $objet);
        }    

        $manager->flush();
    }

    public function getOrder(){         
        return 7;     
    }
}
