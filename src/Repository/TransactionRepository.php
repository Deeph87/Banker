<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

//    /**
//     * @return Transaction[] Returns an array of Transaction objects
//     */

    public function findByAccount(Account $account)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t
        FROM App\Entity\Transaction t
        WHERE t.account = :accountId
        ORDER BY t.id ASC'
        )->setParameter('accountId', $account->getId());

        return $query->execute();


//        $conn = $this->getEntityManager()->getConnection();
//        $query = 'SELECT *
//            FROM transaction
//            WHERE transaction.account_id = :accountId;';
//        $stmt = $conn->prepare($query);
//        $stmt->execute(['accountId' => $account->getId()]);
//        return $stmt->fetchAll();
    }

    /*
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
