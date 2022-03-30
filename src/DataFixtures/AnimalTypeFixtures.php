<?php

namespace App\DataFixtures;

use App\Entity\AnimalType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class AnimalTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Chien");
        $manager->persist($typeAnimal);  
        $this->addReference('type_animal_chien', $typeAnimal);
        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Chat");
        $manager->persist($typeAnimal);  
        $this->addReference('type_animal_chat', $typeAnimal);
        $manager->flush();
    }
    public function getOrder(){         
        return 3;     
    }
}
