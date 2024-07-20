<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function recherche($keyword): array
    {
        $query = $this->createQueryBuilder("l")
            ->leftJoin('l.auteur', 'a')
            ->leftJoin('l.genre', 'g');  
    
        if ($keyword) {
            $query->andWhere('a.nom LIKE :keyword OR a.prenom LIKE :keyword OR l.titre LIKE :keyword OR g.nom LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }
    
        return $query
            ->getQuery()
            ->getResult();
    }
    


    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
