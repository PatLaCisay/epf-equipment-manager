<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function add(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Finds all items whose name or category name contains
     * the searched string.
     *
     * @param string $name The searched string
     * @return array An array of matching items
     */
    public function findByDefaultMatch(string $name): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT i
            FROM App\Entity\Item i
            INNER JOIN App\Entity\Category c
            WITH i.category = c.id
            WHERE i.name LIKE :name
            OR c.name LIKE :name"
        )->setParameter("name", "%" . $name . "%");

        return $query->getResult();
    }

    /**
     * Finds all items whose name contains the searched string.
     *
     * @param string $name The searched string
     * @return array An array of matching items
     */
    public function findByNameMatch(string $name): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT i
            FROM App\Entity\Item i
            WHERE i.name LIKE :name"
        )->setParameter("name", "%" . $name . "%");

        return $query->getResult();
    }

    /**
     * Finds all items whose category name contains the searched string.
     *
     * @param string $name The searched string
     * @return array An array of matching items
     */
    public function findByCategoryMatch(string $name): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT i
            FROM App\Entity\Item i
            INNER JOIN App\Entity\Category c
            WITH i.category = c.id
            WHERE c.name LIKE :name"
        )->setParameter("name", "%" . $name . "%");

        return $query->getResult();
    }

    /**
     * Finds all items that are not borrowed at the time of request.
     *
     * @return array An array of available items
     */
    public function findAvailableNow(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT it
            FROM App\Entity\Item it
            WHERE it.id NOT IN (
                SELECT i.id
                FROM App\Entity\Item i
                LEFT JOIN i.borrow b
                WHERE b.startDate <= CURRENT_DATE()
                AND b.endDate >= CURRENT_DATE()
            )"
        );

        return $query->getResult();
    }

    /**
     * Finds all items that are borrowed at the time of request.
     *
     * @return array An array of rented items
     */
    public function findRentedNow(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT it
            FROM App\Entity\Item it
            WHERE it.id IN (
                SELECT i.id
                FROM App\Entity\Item i
                LEFT JOIN i.borrow b
                WHERE b.startDate <= CURRENT_DATE()
                AND b.endDate >= CURRENT_DATE()
            )"
        );

        return $query->getResult();
    }

//    /**
//     * @return Item[] Returns an array of Item objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
