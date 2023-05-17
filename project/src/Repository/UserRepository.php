<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Group;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function findGroups(User $user): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =  'SELECT * FROM `group`
                INNER JOIN `group_user` ON `group`.`id` = `group_user`.`group_id`
                INNER JOIN `user` ON `group_user`.`user_id` = `user`.`id`
                WHERE `user`.`id` = :userId';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(array('userId'=>$user->getId()));

        return $resultSet->fetchAllAssociative();
    }

    public function isDeletable(User $user){

        if (in_array($user->getRoles(), ['ROLE_ADMIN'])){
            return false;
        }

        $groupRepo=$this->getEntityManager()->getRepository(Group::class);

        $groups = $this->findGroups($user);
        
        if (count($groups) > 0){
            
            foreach($groups as $group){
    
                if (count($groupRepo->findOpenedBorrows($groupRepo->find($group["group_id"])))>0){
                    return false;
                }
            }

        }
        
        return true;
        
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
