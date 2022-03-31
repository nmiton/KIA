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
        $Score->setUser($this->getReference('user1'));
        $Score->setTypeAnimal($this->getReference('typeAnimalChien'));
                $manager->persist($Score);
        $manager->flush();
    }

    public function getOrder(){         
        return 20;     
    }
}
