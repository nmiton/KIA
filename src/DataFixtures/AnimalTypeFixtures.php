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
        $this->addReference('typeAnimalChien', $typeAnimal);

        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Chat");
        $manager->persist($typeAnimal);  
        $this->addReference('typeAnimalChat', $typeAnimal);

        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Dragon");
        $manager->persist($typeAnimal);  
        $this->addReference('typeAnimalDragon', $typeAnimal);

        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Ours");
        $manager->persist($typeAnimal);  
        $this->addReference('typeAnimalOurs', $typeAnimal);

        $typeAnimal = new AnimalType();
        $typeAnimal->setName("Otarie");
        $manager->persist($typeAnimal);  
        $this->addReference('typeAnimalOtarie', $typeAnimal);

        // for ($i=1; $i < 6 ; $i++) { 
        //     $typeAnimal = new AnimalType();
        //     $typeAnimal->setName("typeAnimal".$i);
        //     $manager->persist($typeAnimal);  
        //     $this->addReference('typeAnimal'.$i, $typeAnimal);
        // }
        
        $manager->flush();
    }
    public function getOrder(){         
        return 3;     
    }
}
