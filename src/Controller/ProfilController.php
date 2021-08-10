<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/MonProfil", name= "MonProfil")
     */
    public function MonProfil(Request $request,EntityManagerInterface $entityManager): Response
    {
        $profil = new Participant();
        $profilForm = $this->createForm(ParticipantType::class,$profil);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()){
            $entityManager->persist($profil);
            $entityManager->flush();
        }

        return $this->render('user/MonProfil.html.twig', [
            'participantForm' => $profilForm->createView()
        ]);
    }

    /**
     * @Route("/participant/{id}", name="participant")
     */
    public function participant(int $id, ParticipantRepository $participantRepository): Response
    {
        $participant = $participantRepository->find($id);

        if (!$participant){
            throw $this->createNotFoundException("Le profil du participant n'a pas était trouvé");
        }

        return $this->render('user/Profil.html.twig',[
            "profil" => $participant
        ]);
    }
}
