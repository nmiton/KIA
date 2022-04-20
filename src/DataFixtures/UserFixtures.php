<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){         
        $this->encoder = $encoder;     
    }

    public function load(ObjectManager $manager): void
    {
        $dateTime = new DateTime();
        $user = new User();
        $user->setPseudo('nathan');         
        $user->setEmail('nath.miton@orange.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'nath'));             
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setMoney(0);
        $user->setScore(0);       
        $user->setlastConnection($dateTime);  
        $user ->setIsActive(true);     
        $user->setIsVerified(true);
        $user ->setCreatedAt($dateTime);         
        $manager->persist($user);        
        $this->addReference('nath', $user);
        $user = new User();
        $user->setPseudo('julien');         
        $user->setEmail('julienicar@hotmail.com');
        $user->setPassword($this->encoder->encodePassword($user, 'julien'));             
        $user->setRoles(['ROLE_USER']);        
        $user->setMoney(0);
        $user->setScore(0);       
        $user->setlastConnection($dateTime);  
        $user ->setIsActive(true);     
        $user->setIsVerified(true);
        $user ->setCreatedAt($dateTime);         
        $manager->persist($user);        
        $this->addReference('julien', $user);
        $user = new User();
        $user->setPseudo('geogeo');         
        $user->setEmail('g@g.com');
        $user->setPassword($this->encoder->encodePassword($user, 'geogeo'));             
        $user->setRoles(['ROLE_USER']);        
        $user->setMoney(0);
        $user->setScore(0);       
        $user->setlastConnection($dateTime);  
        $user ->setIsActive(true);     
        $user->setIsVerified(true);
        $user ->setCreatedAt($dateTime);         
        $manager->persist($user);        
        $this->addReference('geogeo', $user);
        // for ($i=1; $i < 6 ; $i++) { 
        //     $user = new User();
        //     $user->setPseudo('user'.$i);         
        //     $user->setEmail('user'.$i.'@domain.fr');
        //     $user->setPassword($this->encoder->encodePassword($user, 'user'.$i));             
        //     $user->setRoles(['ROLE_USER']);        
        //     $user->setMoney(0);
        //     $user->setScore(500+$i*2);       
        //     $user->setlastConnection($dateTime);  
        //     $user ->setIsActive(true);     
        //     $user->setIsVerified(false);
        //     $user ->setCreatedAt($dateTime);         
        //     $manager->persist($user);        
        //     $this->addReference('user'.$i, $user);
        // }
        $manager->flush();
    }

    public function getOrder(){         
        return 2;     
    }
}
