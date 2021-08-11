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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/MonProfil", name= "MonProfil")
     */
    public function MonProfil(Request $request,
                              UserPasswordEncoderInterface $passwordEncoder,
                              EntityManagerInterface $entityManager
    ): Response
    {
        $participant = $this->getUser();

        $participantForm = $this->createForm(ParticipantType::class, $participant);

        $participantForm->handleRequest($request);

        if ($participantForm->isSubmitted() && $participantForm->isValid()){
            $password =$passwordEncoder->encodePassword($participant,$participantForm->get('motPasse')->getData());
            $participant->setMotPasse($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash('success','Vos données ont bien était modifié !');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/MonProfil.html.twig', [
            'participantForm' => $participantForm->createView()
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
            "participant" => $participant
        ]);
    }
}
