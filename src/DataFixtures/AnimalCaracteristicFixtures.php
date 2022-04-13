<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AnimalCaracteristicFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // //stats chien nath
        // $vie = new AnimalCaracteristic();
        // $vie->setCaracteristic($this->getReference('Vie'));
        // $vie->setAnimal($this->getReference('animal_chien1'));
        // $manager->persist($vie);
        // $nourriture = new AnimalCaracteristic();
        // $nourriture->setCaracteristic($this->getReference('Nourriture'));
        // $nourriture->setAnimal($this->getReference('animal_chien1'));
        // $manager->persist($nourriture);
        // $hydratation = new AnimalCaracteristic();
        // $hydratation->setCaracteristic($this->getReference('Hydratation'));
        // $hydratation->setAnimal($this->getReference('animal_chien1'));
        // $manager->persist($hydratation);
        // $energie = new AnimalCaracteristic();
        // $energie->setCaracteristic($this->getReference('Énergie'));
        // $energie->setAnimal($this->getReference('animal_chien1'));
        // $manager->persist($energie);
        // $bonheur = new AnimalCaracteristic();
        // $bonheur->setCaracteristic($this->getReference('Bonheur'));
        // $bonheur->setAnimal($this->getReference('animal_chien1'));
        // $manager->persist($bonheur);
        //stats dragon geogeo
        // $vie = new AnimalCaracteristic();
        // $vie->setCaracteristic($this->getReference('Vie'));
        // $vie->setAnimal($this->getReference('animal_dragon'));
        // $manager->persist($vie);
        // $nourriture = new AnimalCaracteristic();
        // $nourriture->setCaracteristic($this->getReference('Nourriture'));
        // $nourriture->setAnimal($this->getReference('animal_dragon'));
        // $manager->persist($nourriture);
        // $hydratation = new AnimalCaracteristic();
        // $hydratation->setCaracteristic($this->getReference('Hydratation'));
        // $hydratation->setAnimal($this->getReference('animal_dragon'));
        // $manager->persist($hydratation);
        // $energie = new AnimalCaracteristic();
        // $energie->setCaracteristic($this->getReference('Énergie'));
        // $energie->setAnimal($this->getReference('animal_dragon'));
        // $manager->persist($energie);
        // $bonheur = new AnimalCaracteristic();
        // $bonheur->setCaracteristic($this->getReference('Bonheur'));
        // $bonheur->setAnimal($this->getReference('animal_dragon'));
        // $manager->persist($bonheur);
        // for ($i=1; $i<5 ; $i++) { 
        //     $bonheur = new AnimalCaracteristic();
        //     $bonheur->setCaracteristic($this->getReference('Bonheur'));
        //     $bonheur->setAnimal($this->getReference('animal'.$i));
        //     $manager->persist($bonheur);
        // }
        $manager->flush();
    }

    public function getOrder(){         
        return 6;     
    }
}
