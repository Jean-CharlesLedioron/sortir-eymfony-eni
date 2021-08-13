<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\CreateLieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/lieu", name="lieu_")
 */
class LieuController extends AbstractController
{

    /**
     * @Route ("/create", name="create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createSortie(Request $request, EntityManagerInterface $entityManager): Response
    {


        $lieu = new Lieu();

        $lieuForm = $this->createForm(CreateLieuType::class, $lieu);

        dump($lieu);
        $lieuForm->handleRequest($request);
        dump($lieu);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {


            $entityManager->persist($lieu);
            $entityManager->flush();

            $this->addFlash('success', 'lieu créé');
            return $this->redirectToRoute('sortie_create');
        }


        return $this->render('lieu/lieu.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }
}
