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
        //action chien
        $actionSortirParc = new Action();
        $actionSortirParc->setName("Sortir le chien au parc");
        $actionSortirParc->setType("Sortir");
        $actionSortirParc->setConsoleLog(" court dans le parc");
        $actionSortirParc->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($actionSortirParc);
        $this->addReference('sortirParcChien', $actionSortirParc);

        $jouerBalleTennis = new Action();
        $jouerBalleTennis->setName("Jouer à la balle de tennis");
        $jouerBalleTennis->setType("Jouer");
        $jouerBalleTennis->setConsoleLog(" vous ramène la balle");
        $jouerBalleTennis->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($jouerBalleTennis);
        $this->addReference('jouerBalleTennisChien', $jouerBalleTennis);

        $nourrirCroquette = new Action();
        $nourrirCroquette->setName("Nourrir avec des croquettes");
        $nourrirCroquette->setType("Nourrir");
        $nourrirCroquette->setConsoleLog(" se régale");
        $nourrirCroquette->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($nourrirCroquette);
        $this->addReference('nourrirCroquetteChien', $nourrirCroquette);

        $remplirGamelle = new Action();
        $remplirGamelle->setName("Remplir la gamelle d'eau");
        $remplirGamelle->setType("Boire");
        $remplirGamelle->setConsoleLog(" boit");
        $remplirGamelle->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($remplirGamelle);
        $this->addReference('remplirGamelleChien', $remplirGamelle);

        $soinNiv1 = new Action();
        $soinNiv1->setName("Soigner des petits bobos");
        $soinNiv1->setType("Soin");
        $soinNiv1->setConsoleLog(" aime l'attention que vous lui portez");
        $soinNiv1->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($soinNiv1);
        $this->addReference('soinNiv1Chien', $soinNiv1);

        $donnerFriandise = new Action();
        $donnerFriandise->setName("Donner friandise");
        $donnerFriandise->setType("Nourrir");
        $donnerFriandise->setConsoleLog(" adore ce genre de friandise");
        $donnerFriandise->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($donnerFriandise);
        $this->addReference('donnerFriandiseChien', $donnerFriandise);
        // //action type Nourrir chien
        // for ($i=0; $i < 6; $i++) { 
        //     $actionFixture = new Action();
        //     $actionFixture->setName("ActionNourrir".$i);
        //     $actionFixture->setType("Nourrir");
        //     $actionFixture->setConsoleLog(" console log");
        //     $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
        //     $manager->persist($actionFixture);
        //     $this->addReference("ActionNourrir".$i, $actionFixture);
        // }
        // //action type Soin
        // for ($i=0; $i < 6; $i++) { 
        //     $actionFixture = new Action();
        //     $actionFixture->setName("ActionSoin".$i);
        //     $actionFixture->setType("Soin");
        //     $actionFixture->setConsoleLog(" console log");
        //     $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
        //     $manager->persist($actionFixture);
        //     $this->addReference('ActionSoin'.$i, $actionFixture);
        // }
        // //action type Jouer
        // for ($i=0; $i < 6; $i++) { 
        //     $actionFixture = new Action();
        //     $actionFixture->setName("ActionJouer".$i);
        //     $actionFixture->setType("Jouer");
        //     $actionFixture->setConsoleLog(" console log");
        //     $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
        //     $manager->persist($actionFixture);
        //     $this->addReference('ActionJouer'.$i, $actionFixture);
        // }
        // //action type Sortir
        // for ($i=0; $i < 6; $i++) { 
        //     $actionFixture = new Action();
        //     $actionFixture->setName("ActionSortir".$i);
        //     $actionFixture->setType("Sortir");
        //     $actionFixture->setConsoleLog(" console log");
        //     $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
        //     $manager->persist($actionFixture);
        //     $this->addReference('ActionSortir'.$i, $actionFixture);
        // }
        // //action type Boire
        // for ($i=0; $i < 6; $i++) { 
        //     $actionFixture = new Action();
        //     $actionFixture->setName("ActionBoire".$i);
        //     $actionFixture->setType("Boire");
        //     $actionFixture->setConsoleLog(" console log");
        //     $actionFixture->setAnimalType($this->getReference('typeAnimalChien'));
        //     $manager->persist($actionFixture);
        //     $this->addReference('ActionBoire'.$i, $actionFixture);
        // }

        //actions type dragon
        $actionSortirParc = new Action();
        $actionSortirParc->setName("Sortir le dragon");
        $actionSortirParc->setType("Sortir");
        $actionSortirParc->setConsoleLog(" vole.");
        $actionSortirParc->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($actionSortirParc);
        $this->addReference('actionSortirParcDragon', $actionSortirParc);
        $jouerBalleTennis = new Action();
        $jouerBalleTennis->setName("Jouer à la balle de tennis");
        $jouerBalleTennis->setType("Jouer");
        $jouerBalleTennis->setConsoleLog(" vous ramène la balle");
        $jouerBalleTennis->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($jouerBalleTennis);
        $this->addReference('jouerBalleTennisDragon', $jouerBalleTennis);

        $nourrirCroquette = new Action();
        $nourrirCroquette->setName("Nourrir avec des croquettes");
        $nourrirCroquette->setType("Nourrir");
        $nourrirCroquette->setConsoleLog(" se régale");
        $nourrirCroquette->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($nourrirCroquette);
        $this->addReference('nourrirCroquetteDragon', $nourrirCroquette);

        $remplirGamelle = new Action();
        $remplirGamelle->setName("Remplir la gamelle d'eau");
        $remplirGamelle->setType("Boire");
        $remplirGamelle->setConsoleLog(" boit.");
        $remplirGamelle->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($remplirGamelle);
        $this->addReference('remplirGamelleDragon', $remplirGamelle);

        $soinNiv1 = new Action();
        $soinNiv1->setName("Soigner des petits bobos");
        $soinNiv1->setType("Soin");
        $soinNiv1->setConsoleLog(" aime l'attention que vous lui portez");
        $soinNiv1->setAnimalType($this->getReference('typeAnimalChien'));
        $manager->persist($soinNiv1);
        $this->addReference('soinNiv1Dragon', $soinNiv1);

        $donnerFriandise = new Action();
        $donnerFriandise->setName("Donner friandise");
        $donnerFriandise->setType("Nourrir");
        $donnerFriandise->setConsoleLog(" adore ce genre de friandise");
        $donnerFriandise->setAnimalType($this->getReference('typeAnimalDragon'));
        $manager->persist($donnerFriandise);
        $this->addReference('donnerFriandiseDragon', $donnerFriandise);

    
        $manager->flush();
    }

    public function getOrder(){         
        return 9;     
    }
}
