<?php

namespace App\DataFixtures;

use App\Entity\Action;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $actionSortirParc = new Action();
        $actionSortirParc->setName("Sortir le chien au parc");
        $actionSortirParc->setType("Sortir");
        $actionSortirParc->setConsoleLog("Vous promenez votre chienne, et elle adore ça!");
        $actionSortirParc->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($actionSortirParc);
        $this->addReference('actionSortirParc', $actionSortirParc);

        $jouerBalleTennis = new Action();
        $jouerBalleTennis->setName("Jouer à la balle de tennis");
        $jouerBalleTennis->setType("Jouer");
        $jouerBalleTennis->setConsoleLog(" vous ramène la balle");
        $jouerBalleTennis->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($jouerBalleTennis);
        $this->addReference('jouerBalleTennis', $jouerBalleTennis);

        $nourrirCroquette = new Action();
        $nourrirCroquette->setName("Nourrir avec des croquettes");
        $nourrirCroquette->setType("Nourrir");
        $nourrirCroquette->setConsoleLog(" se régale");
        $nourrirCroquette->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($nourrirCroquette);
        $this->addReference('nourrirCroquette', $nourrirCroquette);

        $remplirGamelle = new Action();
        $remplirGamelle->setName("Remplir la gamelle d'eau");
        $remplirGamelle->setType("Boire");
        $remplirGamelle->setConsoleLog("Vous en avez mis partout");
        $remplirGamelle->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($remplirGamelle);
        $this->addReference('remplirGamelle', $remplirGamelle);

        $soinNiv1 = new Action();
        $soinNiv1->setName("Soigner des petits bobos");
        $soinNiv1->setType("Soin");
        $soinNiv1->setConsoleLog("Vous faites vos meilleurs pansements");
        $soinNiv1->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($soinNiv1);
        $this->addReference('soinNiv1', $soinNiv1);

        $donnerFriandise = new Action();
        $donnerFriandise->setName("Donner friandise");
        $donnerFriandise->setType("Nourrir");
        $donnerFriandise->setConsoleLog("Un peu de sucre ne fait pas de mal");
        $donnerFriandise->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($donnerFriandise);
        $this->addReference('donnerFriandise', $donnerFriandise);

        //action type NOurrir
        for ($i=0; $i < 6; $i++) { 
            $actionFixture = new Action();
            $actionFixture->setName("ActionNourrir".$i);
            $actionFixture->setType("Nourrir");
            $actionFixture->setConsoleLog("console log");
            $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
            $manager->persist($actionFixture);
            $this->addReference("ActionNourrir".$i, $actionFixture);
        }

        //action type Soin
        for ($i=0; $i < 6; $i++) { 
            $actionFixture = new Action();
            $actionFixture->setName("ActionSoin".$i);
            $actionFixture->setType("Soin");
            $actionFixture->setConsoleLog("console log");
            $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
            $manager->persist($actionFixture);
            $this->addReference('ActionSoin'.$i, $actionFixture);
        }

        
        //action type Jouer
        for ($i=0; $i < 6; $i++) { 
            $actionFixture = new Action();
            $actionFixture->setName("ActionJouer".$i);
            $actionFixture->setType("Jouer");
            $actionFixture->setConsoleLog("console log");
            $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
            $manager->persist($actionFixture);
            $this->addReference('ActionJouer'.$i, $actionFixture);
        }

        //action type Sortir
        for ($i=0; $i < 6; $i++) { 
            $actionFixture = new Action();
            $actionFixture->setName("ActionSortir".$i);
            $actionFixture->setType("Sortir");
            $actionFixture->setConsoleLog("console log");
            $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
            $manager->persist($actionFixture);
            $this->addReference('ActionSortir'.$i, $actionFixture);
        }

          //action type Boire
        for ($i=0; $i < 6; $i++) { 
            $actionFixture = new Action();
            $actionFixture->setName("ActionBoire".$i);
            $actionFixture->setType("Boire");
            $actionFixture->setConsoleLog("console log");
            $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
            $manager->persist($actionFixture);
            $this->addReference('ActionBoire'.$i, $actionFixture);
        }

    
        $manager->flush();
    }

    public function getOrder(){         
        return 9;     
    }
}
