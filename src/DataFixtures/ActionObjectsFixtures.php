<?php

namespace App\DataFixtures;

use App\Entity\ActionObjects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActionObjectsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //action type chien
        //jouer balle de tennis
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('jouerBalleTennisChien'));
        $var->setObject($this->getReference('balle_tennis'));
        $manager->persist($var);      
        $this->addReference('actionObjectBalleTennisChien', $var);
        //nourrir croquettes
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('nourrirCroquetteChien'));
        $var->setObject($this->getReference('croquettes'));
        $manager->persist($var);      
        $this->addReference('actionObjectCroquetteChien', $var);
        //remplir gamelle
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('remplirGamelleChien'));
        $var->setObject($this->getReference('eau'));
        $manager->persist($var);      
        $this->addReference('actionObjectGamelleChien', $var);
        //remplir gamelle
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('donnerFriandiseChien'));
        $var->setObject($this->getReference('friandise'));
        $manager->persist($var);      
        $this->addReference('actionObjectFriandiseChien', $var);
        $manager->flush();
        //soin
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('soinNiv1Chien'));
        $var->setObject($this->getReference('soin1'));
        $manager->persist($var);      
        $this->addReference('actionObjectSoin1Chien', $var);
        $manager->flush();
        // //object action nourrir
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionObjects();
        //     $var->setQuantity(1);
        //     $var->setAction($this->getReference('ActionNourrir'.$i));
        //     $var->setObject($this->getReference('objetNourrir'.$i));
        //     $manager->persist($var);      
        //     $this->addReference('actionObjectActionNourrir'.$i, $var);
        //     $manager->flush();
        // }
        // //object action boire
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionObjects();
        //     $var->setQuantity(1);
        //     $var->setAction($this->getReference('ActionBoire'.$i));
        //     $var->setObject($this->getReference('objetBoire'.$i));
        //     $manager->persist($var);      
        //     $this->addReference('actionObjectActionBoire'.$i, $var);
        //     $manager->flush();
        // }
        // //object action jouer
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionObjects();
        //     $var->setQuantity(1);
        //     $var->setAction($this->getReference('ActionJouer'.$i));
        //     $var->setObject($this->getReference('objetJouer'.$i));
        //     $manager->persist($var);      
        //     $this->addReference('actionObjectActionJouer'.$i, $var);
        //     $manager->flush();
        // }
        // //object action sortir
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionObjects();
        //     $var->setQuantity(1);
        //     $var->setAction($this->getReference('ActionSortir'.$i));
        //     $var->setObject($this->getReference('objetSortir'.$i));
        //     $manager->persist($var);      
        //     $this->addReference('actionObjectActionSortir'.$i, $var);
        //     $manager->flush();
        // }
        // //object action soin
        // for ($i=0; $i < 6; $i++) { 
        //     $var = new ActionObjects();
        //     $var->setQuantity(1);
        //     $var->setAction($this->getReference('ActionSoin'.$i));
        //     $var->setObject($this->getReference('objetSoin'.$i));
        //     $manager->persist($var);      
        //     $this->addReference('actionObjectActionSoin'.$i, $var);
        // }

        //action type dragon
        //jouer balle de tennis
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('jouerBalleTennisDragon'));
        $var->setObject($this->getReference('balle_tennis'));
        $manager->persist($var);      
        $this->addReference('actionObjectBalleTennisDragon', $var);
        //nourrir croquettes
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('nourrirCroquetteDragon'));
        $var->setObject($this->getReference('croquettes'));
        $manager->persist($var);      
        $this->addReference('actionObjectCroquetteDragon', $var);
        //remplir gamelle
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('remplirGamelleDragon'));
        $var->setObject($this->getReference('eau'));
        $manager->persist($var);      
        $this->addReference('actionObjectGamelleDragon', $var);
        //remplir gamelle
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('donnerFriandiseDragon'));
        $var->setObject($this->getReference('friandise'));
        $manager->persist($var);      
        $this->addReference('actionObjectFriandiseDragon', $var);
        $manager->flush();
        //soin
        $var = new ActionObjects();
        $var->setQuantity(1);
        $var->setAction($this->getReference('soinNiv1Dragon'));
        $var->setObject($this->getReference('soin1'));
        $manager->persist($var);      
        $this->addReference('actionObjectSoin1Dragon', $var);
        $manager->flush();

        $manager->flush();
    }

    public function getOrder(){         
        return 11;     
    }
}
