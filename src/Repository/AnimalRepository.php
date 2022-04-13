<?php

namespace App\Repository;

use App\Entity\Animal;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Animal $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Animal $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Animal[] Returns an array of Animal objects
     */
    public function findAllDeadAnimalsByUser($idUser, $atr)
    {
        $deadAnimals = $this->createQueryBuilder('a')
            ->where("a.user = '$idUser'")
            ->andWhere("a.isAlive = '0'")
            ->getQuery()
            ->getResult();

        $nowDate = new DateTime('now', new DateTimeZone("UTC"));
        $deads = [];
        foreach ($deadAnimals as $dead) {
            $diffDate = $dead->getLastActive()->diff($nowDate);
            if ($diffDate->i < 20 && $diffDate->h < 1 && $diffDate->d < 1 && $diffDate->m < 1 && $diffDate->y < 1) {
                array_push($deads, [
                    "name" => $dead->getName(),
                    "type" => $atr->find($dead->getAnimalType())->getName()
                ]);
            }
        }

        return $deads;
    }

    // /**
    //  * @return Animal[] Returns an array of Animal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Animal
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
