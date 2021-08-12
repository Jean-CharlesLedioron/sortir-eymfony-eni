<?php

namespace App\Repository;

use App\Entity\Campus;
use App\Model\SearchFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Campus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campus[]    findAll()
 * @method Campus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campus::class);
    }

    public function findCampus(SearchFilter $searchFilter): array{
        $query = $this
            ->createQueryBuilder('c')
            ->select('c');
        if(!empty($searchFilter->getCampusForm()))
        {
            $query=$query
                ->andWhere('c.nom LIKE :campusForm')
                ->setParameter('campusForm', "%{$searchFilter->getCampus()}%");
        }
        return $query->getQuery()->getResult();
    }
}
