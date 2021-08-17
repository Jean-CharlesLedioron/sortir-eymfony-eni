<?php

namespace App\Repository;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Model\SearchFilter;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * Récupère les sorties en lien avec les filtres
     * @return Sortie[]
     */
    public function findSearch(SearchFilter $searchFilter, UserInterface $user): array
    {

        $query = $this
            ->createQueryBuilder('s')
            ->select('s');
        if (!empty($searchFilter->getCampus())) {
            $query = $query
                ->andWhere('s.campusSiteOrganisateur = :campus')
                ->setParameter('campus', $searchFilter->getCampus());
        }
        if (!empty($searchFilter->getSearch())) {
            $query = $query
                ->andWhere('s.nom LIKE :search')
                ->setParameter('search', "%{$searchFilter->getSearch()}%");
        }
        if (!empty($searchFilter->getStartDate())) {
            $query = $query
                ->andWhere('s.dateHeureDebut >= :dateMin')
                ->setParameter('dateMin', $searchFilter->getStartDate());
        }
        if (!empty($searchFilter->getEndDate())) {
            $query = $query
                ->andWhere('s.dateHeureDebut <= :dateMax')
                ->setParameter('dateMax', $searchFilter->getEndDate());
        }
        if (!empty($searchFilter->getOrganisator())) {
            $query = $query
                ->andWhere('s.participantOrganisateur = :organisator')
                ->setParameter('organisator', $user);
        }
        if (!empty($searchFilter->getSignIn())) {
            $query = $query
                ->andWhere(':inscrit MEMBER OF s.participantInscrit ')
                ->setParameter('inscrit', $user);
        }
        if (!empty($searchFilter->getNotSignIn())) {
            $query = $query
                ->andWhere(':nonInscrit NOT MEMBER OF s.participantInscrit')
                ->setParameter('nonInscrit', $user);
        }
        if (!empty($searchFilter->getPassed())) {
            $query = $query
                ->andWhere('s.dateLimiteInscription > :date ')
                ->setParameter('date', 'NOW()');
        }


        return $query->getQuery()->getResult();


    }


    /**
     * Récupère toutes les sorties
     * @return Sortie[]
     */
    public function findAllSorties(): array
    {
        $query= $this->findAll();
        return $query;

    }

    public function stateRefresh(EntityManagerInterface $entityManager){
        $sorties = $this->findAllSorties();
        foreach ($sorties as $sortie){
            $etatSortie = $sortie->getEtat()->getLibelle();
            $datetimeNow = new \DateTime();
            $decalageUTC = 120;
            $datetimeNow->add(new \DateInterval('PT'.$decalageUTC.'M'));
            if ($etatSortie != 'Créée' or $etatSortie != 'Annulée' or $etatSortie != 'Passée')
            {
                if ($etatSortie === 'Ouverte'){
                    if ($sortie->getDateLimiteInscription() <= $datetimeNow) {
                        $etatSortie = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
                        $sortie->setEtat($etatSortie);
                    }
                }elseif ($etatSortie === 'Clôturée'){
                    if ($sortie->getDateHeureDebut() <= $datetimeNow) {
                        dump("plop");
                        $etatSortie = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'Activité en cours']);
                        $sortie->setEtat($etatSortie);
                    }
                }elseif ($etatSortie === 'Activité en cours'){
                    $dateEndEvent = $sortie->getDateHeureDebut();
                    $duree=$sortie->getDuree();
                    $dateEndEvent->add(new \DateInterval('PT'.$sortie->getDuree().'M'));
                    if ($dateEndEvent <= $datetimeNow) {
                        $etatSortie = $entityManager->getRepository(Etat::class)->findOneBy(['libelle' => 'Passée']);
                        $sortie->setEtat($etatSortie);
//                        $entityManager->flush($sortie);
                    }
                }
                $entityManager->flush($sortie);
            }
        }
    }


}
