<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Salle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salle[]    findAll()
 * @method Salle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    public function countSalles()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findMatieres() {
        return $this->createQueryBuilder('matieres')
            -> select('s.matiere')
            -> distinct(true)
            -> from(Salle::class, 's')
            -> orderBy('s.matiere', 'ASC')
            -> getQuery()
            -> getResult();
    }

    public function findTailles() {
        return $this->createQueryBuilder('tailles')
            -> select('s.taille')
            -> distinct(true)
            -> from(Salle::class, 's')
            -> orderBy('s.taille', 'ASC')
            -> getQuery()
            -> getResult();
    }

    public function findCouleurs() {
        return $this->createQueryBuilder('couleurs')
            -> select('s.couleur')
            -> distinct(true)
            -> from(Salle::class, 's')
            -> orderBy('s.couleur', 'ASC')
            -> getQuery()
            -> getResult();
    }
}
