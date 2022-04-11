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
        //Animal de julien
        $animal = new Animal();
        $animal->setName("JeRoule");
        $animal->setIsAlive(true);
        $animal->setLastActive($date);
        $animal->setCreatedAt($date);
        $animal->setUser($this->getReference('geogeo'));
        $animal->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($animal);
        $this->addReference('animal_dragon', $animal);
        //Animal de nathan 
        $animal = new Animal();
        $animal->setName("Roxy");
        $animal->setIsAlive(true);
        $animal->setLastActive($date);
        $animal->setCreatedAt($date);
        $animal->setUser($this->getReference('nath'));
        $animal->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($animal);
        $this->addReference('animal_chien', $animal);
        //Animal de julien
        // $animal = new Animal();
        // $animal->setName("Bob");
        // $animal->setIsAlive(true);
        // $animal->setLastActive($date);
        // $animal->setCreatedAt($date);
        // $animal->setUser($this->getReference('julien'));
        // $animal->setAnimalType($this->getReference('typeAnimalOtarie'));
        // $manager->persist($animal);
        // $this->addReference('animal_otarie', $animal);

        // for ($i=1; $i<5 ; $i++) { 
        //     $animal = new Animal();
        //     $animal->setName("animal".$i);
        //     $animal->setIsAlive(true);
        //     $animal->setLastActive($date);
        //     $animal->setCreatedAt($date);
        //     $animal->setUser($this->getReference('user'.$i));
        //     $animal->setAnimalType($this->getReference('typeAnimal'.$i));
        //     $manager->persist($animal);
        //     $this->addReference('animal'.$i, $animal);
        // }

        $manager->flush();
    }

    public function getOrder(){         
        return 5;     
    }
}
