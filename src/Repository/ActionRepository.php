<?php

namespace App\Repository;

use App\Entity\Action;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Action|null find($id, $lockMode = null, $lockVersion = null)
 * @method Action|null findOneBy(array $criteria, array $orderBy = null)
 * @method Action[]    findAll()
 * @method Action[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Action $entity, bool $flush = true): void
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
    public function remove(Action $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findTypeAction()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT DISTINCT type FROM `action`
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findTypeActionByAnimalType($animalType)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT DISTINCT type FROM `action` WHERE animal_type_id = :animalType
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['animalType' => $animalType]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByActionsAnimalTypeAndActionType($animalTypeId,$actionType)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT a.id, a.name, a.type, a.console_log FROM action a 
        INNER JOIN action_caracteristic ac ON ac.action_id = a.id 
        INNER JOIN caracteristic c on c.id = ac.caracteritic_id 
        WHERE animal_type_id = :animalTypeId AND type=:actionType GROUP BY a.id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['animalTypeId' => $animalTypeId,'actionType'=>$actionType]);
        return $resultSet->fetchAllAssociative();
    }

    public function findByStatsActionsByAnimalTypeAndActionType($animalTypeId,$actionType)
    {
        $conn = $this->getEntityManager()->getConnection();    
        $sql = '
        SELECT a.id, c.name, ac.val_max, ac.val_min FROM action a 
            INNER JOIN action_caracteristic ac ON ac.action_id = a.id 
            INNER JOIN caracteristic c on c.id = ac.caracteritic_id 
            WHERE animal_type_id = :animalTypeId AND type=:actionType ORDER BY ac.val_max DESC ;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['animalTypeId' => $animalTypeId,'actionType'=>$actionType]);
        return $resultSet->fetchAllAssociative();
    }

    public function findByActionsAnimalTypeAndActionTypeWhereObjectsInInventory($animalTypeId,$actionType,$userId)
    {
        $conn = $this->getEntityManager()->getConnection();    
        $sql = '
        SELECT DISTINCT a.id, a.name, a.type, a.console_log FROM action a 
        INNER JOIN action_caracteristic ac ON ac.action_id = a.id 
        INNER JOIN caracteristic c on c.id = ac.caracteritic_id 
        WHERE animal_type_id = :animalTypeId AND type=:actionType
        AND a.id IN 
            (SELECT a.id FROM inventory i 
            INNER JOIN objects o on o.id = i.objet_id 
            INNER JOIN action_objects ao on ao.object_id = o.id 
            INNER JOIN action a on a.id = ao.action_id 
            WHERE a.type=:actionType AND i.user_id = :userId
            GROUP BY i.objet_id) 
        GROUP BY a.id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['animalTypeId' => $animalTypeId,'actionType'=>$actionType,'userId'=>$userId]);
        return $resultSet->fetchAllAssociative();
    }


    // /**
    //  * @return Action[] Returns an array of Action objects
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
    public function findOneBySomeField($value): ?Action
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
