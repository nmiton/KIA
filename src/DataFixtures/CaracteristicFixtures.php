<?php

namespace App\DataFixtures;
use App\Entity\Caracteristic;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Animal;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CaracteristicFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $vie = new Caracteristic();
        $vie->setName("Vie");
        $vie->setLostByHour(2);
        $manager->persist($vie);
        $this->addReference('Vie', $vie);

        $nourriture = new Caracteristic();
        $nourriture->setName("Nourriture");
        $nourriture->setLostByHour(4);
        $manager->persist($nourriture);
        $this->addReference('Nourriture', $nourriture);

        $hydratation = new Caracteristic();
        $hydratation->setName("Hydratation");
        $hydratation->setLostByHour(5);
        $manager->persist($hydratation);
        $this->addReference('Hydratation', $hydratation);

        $energie = new Caracteristic();
        $energie->setName("Énergie");
        $energie->setLostByHour(0);
        $manager->persist($energie);
        $this->addReference('Énergie', $energie);

        $humeur = new Caracteristic();
        $humeur->setName("Humeur");
        $humeur->setLostByHour(4);
        $manager->persist($humeur);
        $this->addReference('Humeur', $humeur);

        $manager->flush();
    }

    public function getOrder(){         
        return 4;     
    }
}
