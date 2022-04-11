<?php

namespace App\DataFixtures;
use App\Entity\Score;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ScoreFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $Score = new Score();
        $Score->setScore(10);
        $Score->setName("roxy");
        $Score->setUser($this->getReference('nath'));
        $Score->setTypeAnimal($this->getReference('typeAnimalChien'));
        $manager->persist($Score);
        $Score = new Score();
        $Score->setScore(50);
        $Score->setName("animal_dragon");
        $Score->setUser($this->getReference('geogeo'));
        $Score->setTypeAnimal($this->getReference('typeAnimalDragon'));
        $manager->persist($Score);
        $Score = new Score();
    }

    public function getOrder(){         
        return 20;     
    }
}
