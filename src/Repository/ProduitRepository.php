<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function countProduitsDispo()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countStocks()
    {
        return $this->createQueryBuilder('t')
            ->select('sum(t.stock)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function removeFromStock($product)
    {
        return $this->createQueryBuilder('f')
            ->update($this->getEntityName(), 'f')
            ->set('f.stock', $product->getStock() - 1)
            ->where('f.id = :id')->setParameter('id', $product->getId())
            ->getQuery()
            ->execute();
    }
}
