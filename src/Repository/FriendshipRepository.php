<?php

namespace App\Repository;

use App\Entity\Friendship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Friendship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friendship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friendship[]    findAll()
 * @method Friendship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendshipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Friendship::class);
    }

    /**
     * Retrieve current friend invites for the notification timeline
     * @param String The user ID
     * @return Friendship[] Returns an array of Friendship objects
     */

    public function findMyFriendInvites($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.friend = :val')
            ->setParameter('val', $value)
            ->andWhere('f.status = 0')
            ->orderBy('f.updatedAt')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Friendship
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
