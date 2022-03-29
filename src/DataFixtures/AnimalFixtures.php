<?php

namespace App\DataFixtures;
use App\Entity\Animal;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\AnimalType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AnimalFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $date = new DateTime();
        $animal = new Animal();
        $animal->setName("Roxy");
        $animal->setIsAlive(true);
        $animal->setLastActive($date);
        $animal->setCreatedAt($date);
        $animal->setUser($this->getReference('user1'));
        $animal->setAnimalType($this->getReference('type_animal_chien'));
        $manager->persist($animal);
        $manager->flush();
    }

    public function getOrder(){         
        return 4;     
    }
}
