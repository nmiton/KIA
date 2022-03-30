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
        $user = new User();
        $user->setPseudo('nathan');         
        $user->setEmail('nathan.miton@orange.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'nath'));             
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setMoney(254444444);       
        $user->setlastConnection(new DateTime());  
        $user ->setIsActive(true);     
        $user->setIsVerified(true);
        $user ->setCreatedAt(new \DateTime());         
        $manager->persist($user);        
        $this->addReference('user1', $user);
        $manager->flush();
    }

    public function getOrder(){         
        return 2;     
    }
}
