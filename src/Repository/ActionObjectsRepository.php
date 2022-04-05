<?php

namespace App\Repository;

use App\Entity\ActionObjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActionObjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionObjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionObjects[]    findAll()
 * @method ActionObjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionObjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionObjects::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ActionObjects $entity, bool $flush = true): void
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
    public function remove(ActionObjects $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    
    public function findByActionIdLossPercentage($actionId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT o.id, o.loss_percentage, o.name 
        FROM action_objects ao 
        INNER JOIN objects o on o.id = ao.object_id 
        WHERE ao.action_id = :actionId";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['actionId' => $actionId]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    

    /*
    public function findOneBySomeField($value): ?ActionObjects
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
