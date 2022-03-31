<?php

namespace App\DataFixtures;

use App\Entity\Inventory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class InventoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $inv = new Inventory();
        $inv->setUser($this->getReference('nath'));
        $inv->setObjet($this->getReference('balle_tennis'));
        $manager->persist($inv);        
        $manager->flush();
    }

    public function getOrder(){         
        return 8;     
    }
}
