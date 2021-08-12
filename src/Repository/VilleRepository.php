<?php

namespace App\Repository;

use App\Entity\Ville;
use App\Model\SearchFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function findCity(SearchFilter $searchFilter): array{
        $query = $this
            ->createQueryBuilder('v')
            ->select('v');
        if(!empty($searchFilter->getVille()))
        {
            $query=$query
                ->andWhere('v.nom LIKE :ville')
                ->setParameter('ville', "%{$searchFilter->getVille()}%");
        }
        return $query->getQuery()->getResult();
    }
}
