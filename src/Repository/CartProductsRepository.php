<?php

namespace App\Repository;

use App\Entity\CartProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartProducts>
 *
 * @method CartProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartProducts[]    findAll()
 * @method CartProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartProducts::class);
    }

    public function save(CartProducts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CartProducts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    

    /**
    * @return CartProducts Returns an array of CartProducts objects
    */
    public function findByIdProduct($value): CartProducts
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
       ;
    }

//    public function findOneBySomeField($value): ?CartProducts
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
