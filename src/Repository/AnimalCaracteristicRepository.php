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

        
    public function findByAnimalStatsIsAliveWithUserId($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT ac.animal_id, c.name, ac.value, c.lost_by_hour
            FROM animal_caracteristic ac
            INNER JOIN animal a on a.id = ac.animal_id
            INNER JOIN user u on a.user_id = u.id
            INNER JOIN caracteristic c on ac.caracteristic_id= c.id
            WHERE user_id = :userId
            AND is_alive = 1 ORDER BY ac.caracteristic_id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);

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
