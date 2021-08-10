<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

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

    /*public function updateById(Participant $participant){
        $queryBulder = $this->createQueryBuilder();
        $query = $queryBulder -> update('Participant','p')
                -> set('p.nom',':nom')
                -> set('p.prenom',':prenom')
                -> set('p.pseudo',':pseudo')
                -> set('p.telephone',':telephone')
                -> set('p.mail',':mail')
                -> set('p.mot_passe',':mot_passe')
                -> set('p.campus_id',':campus_id')
                -> where('p.id = :id')
                -> setParameter('nom',$participant->getNom())
                -> setParameter('prenom',$participant->getPrenom())
                -> setParameter('pseudo',$participant->getPseudo())
                -> setParameter('telephone',$participant->getTelephone())
                -> setParameter('mail',$participant->getMail())
                -> setParameter('mot_passe',$participant->getMotPasse())
                -> setParameter('campus_id',$participant->getCampus())
                -> getQuery();
        $result = $query -> execute();
        return $result;
    }*/
}
