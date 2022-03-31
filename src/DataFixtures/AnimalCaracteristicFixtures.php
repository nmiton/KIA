<?php

namespace App\DataFixtures;
use App\Entity\AnimalCaracteristic;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Animal;
use App\Entity\Caracteristic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AnimalCaracteristicFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $vie = new AnimalCaracteristic();
        $vie->setValue(100);
        $vie->setCaracteristic($this->getReference('Vie'));
        $vie->setAnimal($this->getReference('animal1'));
        $manager->persist($vie);

        $nourriture = new AnimalCaracteristic();
        $nourriture->setValue(100);
        $nourriture->setCaracteristic($this->getReference('Nourriture'));
        $nourriture->setAnimal($this->getReference('animal1'));
        $manager->persist($nourriture);

        $hydratation = new AnimalCaracteristic();
        $hydratation->setValue(100);
        $hydratation->setCaracteristic($this->getReference('Hydratation'));
        $hydratation->setAnimal($this->getReference('animal1'));
        $manager->persist($hydratation);

        $energie = new AnimalCaracteristic();
        $energie->setValue(100);
        $energie->setCaracteristic($this->getReference('Énergie'));
        $energie->setAnimal($this->getReference('animal1'));
        $manager->persist($energie);

        $bonheur = new AnimalCaracteristic();
        $bonheur->setValue(100);
        $bonheur->setCaracteristic($this->getReference('Bonheur'));
        $bonheur->setAnimal($this->getReference('animal1'));
        $manager->persist($bonheur);

        $manager->flush();
    }

    public function getOrder(){         
        return 6;     
    }
}
