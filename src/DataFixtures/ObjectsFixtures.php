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
        $this->addReference('objet1', $objet);
        $objet = new Objects();
        $objet->setName("Freezbee");
        $objet->setDescription("Jeu en forme d'assiette avec la capacité de retour et de non retour");
        $objet->setPrice(20);
        $objet->setLossPercentage(50);
        $manager->persist($objet);         
        $this->addReference('objet2', $objet);
        $manager->flush();
    }

    public function getOrder(){         
        return 7;     
    }
}
