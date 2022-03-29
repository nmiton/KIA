<?php

namespace App\Repository;

use App\Entity\AnimalCaracteristic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnimalCaracteristic|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalCaracteristic|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalCaracteristic[]    findAll()
 * @method AnimalCaracteristic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalCaracteristicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalCaracteristic::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AnimalCaracteristic $entity, bool $flush = true): void
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
    public function remove(AnimalCaracteristic $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllStatsByAnimalId($animalId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT animal_caracteristic.value,caracteristic.name 
            FROM animal_caracteristic 
            INNER JOIN caracteristic 
            WHERE animal_id = :animalId 
            GROUP BY  caracteristic.id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['animalId' => $animalId]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }


    /*
    public function findOneBySomeField($value): ?AnimalCaracteristic
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
