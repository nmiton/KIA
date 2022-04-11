<?php

namespace App\Repository;

use App\Entity\Objects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Objects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objects[]    findAll()
 * @method Objects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objects::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Objects $entity, bool $flush = true): void
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
    public function remove(Objects $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByCountAllObjetsByUserId($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(o.id) as quantity,
            o.id, o.description, o.name, o.price, o.loss_percentage 
            FROM objects o 
            INNER JOIN inventory i ON o.id = i.objet_id
            WHERE i.user_id = :userId 
            GROUP BY o.id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function findByCountAllObjetsByUserIdAndActionType($userId,$actionType)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(o.id) as quantity,
            o.id, o.description, o.name, o.price, o.loss_percentage 
            FROM objects o 
            INNER JOIN action_objects ao ON ao.object_id = o.id
            INNER JOIN action a on a.id = ao.action_id
            INNER JOIN inventory i ON o.id = i.objet_id
            WHERE i.user_id = :userId 
            AND a.type = :actionType
            GROUP BY o.id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId,"actionType"=>$actionType]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByActionType($typeName): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT o.id,o.price, o.name, o.loss_percentage, o.description
        from objects o 
        INNER JOIN action_objects ao ON o.id = ao.object_id
        INNER JOIN action a ON a.id = ao.action_id
        WHERE a.type = :typeName";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['typeName' => $typeName]);
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    
    public function findByActionTypeOrderByPriceDesc($typeName): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT o.id,o.price, o.name, o.loss_percentage, o.description
        from objects o 
        INNER JOIN action_objects ao ON o.id = ao.object_id
        INNER JOIN action a ON a.id = ao.action_id
        WHERE a.type = :typeName ORDER BY o.price DESC";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['typeName' => $typeName]);
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByActionTypeOrderByPriceAsc($typeName): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT o.id,o.price, o.name, o.loss_percentage, o.description
        from objects o 
        INNER JOIN action_objects ao ON o.id = ao.object_id
        INNER JOIN action a ON a.id = action_id
        WHERE a.type = :typeName ORDER BY o.price ASC";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['typeName' => $typeName]);
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByOrderByPriceAsc(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT o.id,o.price, o.name, o.loss_percentage, o.description
        from objects o 
        INNER JOIN action_objects ao ON o.id = ao.object_id
        INNER JOIN action a ON a.id = action_id
        ORDER BY o.price ASC";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByOrderByPriceDesc(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT o.id,o.price, o.name, o.loss_percentage, o.description
        from objects o 
        INNER JOIN action_objects ao ON o.id = ao.object_id
        INNER JOIN action a ON a.id = action_id
        ORDER BY o.price DESC";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    // /**
    //  * @return Objects[] Returns an array of Objects objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objects
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
