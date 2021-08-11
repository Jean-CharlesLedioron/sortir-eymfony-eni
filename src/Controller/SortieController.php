<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\CreateSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("/sortie", name="sortie_")
 */
class SortieController extends AbstractController
{
    /**
     * @Route ("/create", name="create")
     */
    public function createSortie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $username = $this->getUser()->getUsername();
        $organisateur = $this->getDoctrine()->getRepository(Participant::class)->findOneByPseudoOrEmail($username);
        $sortie = new Sortie();
        $sortie->setParticipantOrganisateur($organisateur);
        $sortie-> setCampusSiteOrganisateur($organisateur->getCampus());
        $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle'=>'Créée']);
        $sortie -> setEtat($etat);
        $sortieForm = $this->createForm(CreateSortieType::class, $sortie);

        dump($sortie);
        $sortieForm->handleRequest($request);
        dump($sortie);

        if($sortieForm->isSubmitted() && $sortieForm->isValid()){

            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'sortie créée');
            return $this->redirectToRoute('sortie_create');
        }


        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }
}
