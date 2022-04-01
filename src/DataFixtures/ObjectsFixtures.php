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

        $objet = new Objects();
        $objet->setName("Croquettes");
        $objet->setPrice(15);
        $objet->setDescription("Croquettes caloriques");
        $objet->setLossPercentage(100);
        $manager->persist($objet);
        $this->addReference('croquettes', $objet);

        $objet = new Objects();
        $objet->setName("Friandise");
        $objet->setPrice(15);
        $objet->setDescription("Petit bonbon caramélisé");
        $objet->setLossPercentage(100);
        $manager->persist($objet);
        $this->addReference('friandise', $objet);

        $objet = new Objects();
        $objet->setName("Eau");
        $objet->setPrice(2);
        $objet->setDescription("Eau minéral en bouteille");
        $objet->setLossPercentage(100);
        $manager->persist($objet);
        $this->addReference('eau', $objet);

        $objet = new Objects();
        $objet->setName("Soin niveau 1");
        $objet->setPrice(150);
        $objet->setDescription("Soigner les petits bobos de votre animal");
        $objet->setLossPercentage(100);
        $manager->persist($objet);
        $this->addReference('soin1', $objet);


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
