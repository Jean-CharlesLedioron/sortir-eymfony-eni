<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function findOneByPseudoOrEmail($username)
    {
        return $this->createQueryBuilder('p')
            ->where('p.pseudo = :username OR p.mail = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function removeUser(Participant $participant)
    {
        $query = $this
            ->createQueryBuilder('p')
            ->delete()
            ->where('p.id =:id')
            ->setParameter('id',$participant->getId());

        return $query->getQuery()->getResult();
    }
}
