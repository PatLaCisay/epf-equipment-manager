<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\Group;
use App\Entity\Borrow;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Borrow>
 *
 * @method Borrow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrow[]    findAll()
 * @method Borrow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrow::class);
    }

    public function add(Borrow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Borrow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findItems(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT it
            FROM App\Entity\Item it
            WHERE it.id IN (
                SELECT i.id
                FROM App\Entity\ItemBorrow ib
                LEFT JOIN ib.item i
                LEFT JOIN ib.borrow b
            )"
        );

        return $query->getResult();
    }

    public function findQuantity(Item $item) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
        SELECT b.quantity
        FROM App\Entity\ItemBorrow b
        WHERE b.item = :itemId
        ');
        $query->setParameter('itemId', $item->getId());

        dd($query->getScalarResult());
    }

//    /**
//     * @return Borrow[] Returns an array of Borrow objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Borrow
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
