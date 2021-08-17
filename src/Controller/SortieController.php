<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\CancelSortieType;
use App\Form\CreateSortieType;
use App\Form\EditSortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createSortie(Request $request, EntityManagerInterface $entityManager): Response
    {

        $organisateur = $this->getUser();
        $sortie = new Sortie();
        $sortie->setParticipantOrganisateur($organisateur);
        $sortie->setCampusSiteOrganisateur($organisateur->getCampus());
        if (isset($_POST['save'])) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Créée']);
            $sortie->setEtat($etat);
        } else if (isset($_POST['publish'] )) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
            $sortie->setEtat($etat);
        }

        $sortieForm = $this->createForm(CreateSortieType::class, $sortie);

        dump($sortie);
        $sortieForm->handleRequest($request);
        dump($sortie);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'sortie créée');
            return $this->redirectToRoute('main_home');
        }


        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route ("/publish/{id}", name="publish")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function publishSortie(EntityManagerInterface $entityManager, Request $request, $id): Response{
        $sortie=$this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie->setEtat($etat);
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success','sortie publiée');
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route ("/cancel/{id}", name="cancel")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     */
    function cancelSortie(EntityManagerInterface $entityManager, Request $request, $id): Response
    {

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);


        $cancelForm = $this->createForm(CancelSortieType::class, $sortie);
        $cancelForm->handleRequest($request);

        if ($cancelForm->isSubmitted() && $cancelForm->isValid()) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Annulée']);
            $sortie->setEtat($etat);
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'sortie annulée');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('sortie/cancel.html.twig', [
            'cancelForm' => $cancelForm->createView(),
        ]);
    }

    /**
     * @Route ("/edit/{id}", name="edit")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     */
    function editSortie(EntityManagerInterface $entityManager, Request $request, $id): Response
    {

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);

        $editForm = $this->createForm(EditSortieType::class, $sortie);
        if (isset($_POST['save'])) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Créée']);
            $sortie->setEtat($etat);
        } else if (isset($_POST['publish'])) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
            $sortie->setEtat($etat);
        } else if (isset($_POST['cancel'])) {
            return $this->redirectToRoute('sortie_cancel', ['id' => $sortie->getId()]);
        }
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted()){
            $entityManager=$this->getDoctrine()->getManager();

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'sortie modifiée');
            return $this->redirectToRoute('sortie_edit', ['id' => $sortie->getId()]);
        }

            return $this->render('sortie/edit.html.twig', [
                'editForm' => $editForm->createView(),
            ]);
        }

        /**
         * @Route("listLieuxByVille", name="list_lieu")
         */
        public
        function listLieuxByVille(Request $request): JsonResponse
        {

            $villeId = $request->query->get('villeId');
            $ville = $this->getDoctrine()->getManager()->getRepository(Ville::class)->find($villeId);
            $cdp = $ville->getCodePostal();

            $lieux = $this->getDoctrine()->getManager()->getRepository(Lieu::class)->findLieuByVille($villeId);

            $responseArray = array();
            foreach ($lieux as $lieu) {
                $responseArray[] = array(
                    "id" => $lieu->getId(),
                    "name" => $lieu->getNom(),
                    "rue" => $lieu->getRue(),
                    "latitude" => $lieu->getLatitude(),
                    "longitude" => $lieu->getLongitude(),
                    "cdp" => $cdp,

                );
            }
            return new JsonResponse($responseArray);
        }

        /**
         * @Route("lieuDetails", name="lieu_details")
         * @param Request $request
         * @return JsonResponse
         */
        public
        function lieuDetails(Request $request): JsonResponse
        {

            $lieuId = $request->query->get('lieuId');
            $lieu = $this->getDoctrine()->getManager()->getRepository(Lieu::class)->find($lieuId);

            $retourArray = array();

            $retourArray[] = array(
                "id" => $lieu->getId(),
                "name" => $lieu->getNom(),
                "rue" => $lieu->getRue(),
                "latitude" => $lieu->getLatitude(),
                "longitude" => $lieu->getLongitude(),
            );
            return new JsonResponse($retourArray);
        }


        /**
         * @Route("/display/{id}", name="display")
         */
        public
        function display(int $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
        {
            $sortieRepository->stateRefresh($entityManager);
            $sortieDisplay = $sortieRepository->find($id);

        if (!$sortieDisplay) {
            throw $this->createNotFoundException("Cette sortie n'a pas était trouvé");
        }

        return $this->render('sortie/display.html.twig', [
            "sortieDisplay" => $sortieDisplay
        ]);
    }

    /**
     * @Route("/sign/in/{id}", name="sign_in")
     */
    public function signIn(int $id, EntityManagerInterface $entityManager): Response
    {
        $participant = $this->getUser();
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if ($sortie->getEtat()->getLibelle() === 'Ouverte') {
            $sortie->addParticipantInscrit($participant);
            if ($sortie->getParticipantInscrit()->count() == $sortie->getNbInscriptionsMax()) {
                $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Cloturée']);
                $sortie->setEtat($etat);
            }
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', "Inscrit à l'activité : " . $sortie->getNom());
        }

        return $this->redirectToRoute('main_home');
    }


    /**
     * @Route("/sign/out/{id}", name="sign_out")
     */
    public function signOut(int $id, EntityManagerInterface $entityManager): Response
    {
        $participant = $this->getUser();
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $dateJour = new \DateTime();
        //dd($dateJour, $sortie);

        if ($sortie->getEtat()->getLibelle() === 'Ouverte' || $sortie->getEtat()->getLibelle() === 'Cloturée') {
            $sortie->removeParticipantInscrit($participant);
            $dateLimit =$sortie->getDateLimiteInscription();
            if ($dateLimit > $dateJour) {
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
            $sortie->setEtat($etat);
             }
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', "Désinscrit de l'activité : " . $sortie->getNom());
        }

        return $this->redirectToRoute('main_home');
    }
}
