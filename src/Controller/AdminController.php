<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Ville;
use App\Form\AddCampusType;
use App\Form\AddCityType;
use App\Form\CampusModifiedType;
use App\Form\CampusSearchType;
use App\Form\CityModifiedType;
use App\Form\CreateUserType;
use App\Form\VilleSearchType;
use App\Model\SearchFilter;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use App\Repository\VilleRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin", name= "admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/ville", name= "ville")
     */
    public function ville(EntityManagerInterface $entityManager,
                          VilleRepository $villeRepository,
                          Request $request
    ): Response
    {
        //sys filtre
        $searchFilter = new SearchFilter();
        $form = $this->createForm(VilleSearchType::class,$searchFilter);
        $form->handleRequest($request);
        $villes=$villeRepository->findCity($searchFilter);

        //sys ajout
        $ville= new Ville();
        $villeForm = $this->createForm(AddCityType::class,$ville);
        $villeForm->handleRequest($request);
        if ($villeForm->isSubmitted() && $villeForm->isValid()){
            $entityManager->persist($ville);
            $entityManager->flush();
            return $this->redirectToRoute('admin_ville');
        }

        return $this->render('admin/ville.html.twig', [
            'villes'=>$villes,
            'formVille'=>$form->createView(),
            'addvilleForm' => $villeForm->createView()
        ]);
    }

    /**
     * @Route("/ville/remove/{id}", name= "ville_remove")
     */
    public function villeRemove(Ville $ville,
                                VilleRepository $villeRepository,
                                EntityManagerInterface $entityManager
    )
    {
        $ville = $villeRepository->removeCampus($ville);
        return $this->redirectToRoute('admin_ville');
    }

    /**
     * @Route("/ville/modified/{id}", name= "ville_modified")
     */
    public function villeModified(int $id,
                                  Request $request,
                                  EntityManagerInterface $entityManager,
                                  VilleRepository $villeRepository
    ):Response
    {
        $ville = $villeRepository->find($id);
        $villeForm =  $this->createForm(CityModifiedType::class,$ville);
        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted() && $villeForm->isValid()){
            $entityManager->persist($ville);
            $entityManager->flush();
            $this->addFlash('success','Vos données ont bien était modifié !');
            return $this->redirectToRoute('admin_ville');
        }

        return $this->render('admin/villeModified.html.twig', [
            'villeForm' => $villeForm->createView(),
            'ville'=>$ville
        ]);
    }

    /**
     * @Route("/campus", name= "campus")
     */
    public function campus(EntityManagerInterface $entityManager,
                           CampusRepository  $campusRepository,
                           Request $request
    ): Response
    {
        //sys filtre
        $searchFilter = new SearchFilter();
        $form = $this->createForm(CampusSearchType::class,$searchFilter);
        $form->handleRequest($request);
        $campus=$campusRepository->findCampus($searchFilter);

        //sys ajout
        $camp= new Campus();
        $campusForm = $this->createForm(AddCampusType::class,$camp);
        $campusForm->handleRequest($request);
        if ($campusForm->isSubmitted() && $campusForm->isValid()){
            $entityManager->persist($camp);
            $entityManager->flush();
            return $this->redirectToRoute('admin_campus');
        }

        return $this->render('admin/campus.html.twig', [
            'campus'=>$campus,
            'formCampus'=>$form->createView(),
            'addcampusForm' => $campusForm->createView()
        ]);
    }

    /**
     * @Route("/campus/remove/{id}", name= "campus_remove")
     */
    public function campusRemove(Campus $campus,
                                 CampusRepository $campusRepository,
                                 EntityManagerInterface $entityManager
    )
    {
        $campus = $campusRepository->removeCampus($campus);
        return $this->redirectToRoute('admin_campus');
    }

    /**
     * @Route("/campus/modified/{id}", name= "campus_modified")
     */
    public function campusModified(int $id,
                                  Request $request,
                                  EntityManagerInterface $entityManager,
                                  CampusRepository $campusRepository
    ):Response
    {
        $campus = $campusRepository->find($id);
        $campusForm =  $this->createForm(CampusModifiedType::class,$campus);
        $campusForm->handleRequest($request);

        if ($campusForm->isSubmitted() && $campusForm->isValid()){
            $entityManager->persist($campus);
            $entityManager->flush();
            $this->addFlash('success','Vos données ont bien était modifié !');
            return $this->redirectToRoute('admin_campus');
        }

        return $this->render('admin/campusModified.html.twig', [
            'campusForm' => $campusForm->createView(),
            'campus'=>$campus
        ]);
    }

    /**
     * @Route("/dashboard", name= "dashboard")
     */
    public function dashboardCreateUser(Request $request,
                                        ParticipantRepository $participantRepository,
                                        EntityManagerInterface $entityManager,
                                        UserPasswordEncoderInterface $passwordEncoder
    ):Response
    {
        $user = new Participant();
        $userForm = $this->createForm(CreateUserType::class,$user);

        $participant=$participantRepository->findAll();

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()){
            $password =$passwordEncoder->encodePassword($user,$userForm->get('motPasse')->getData());
            $user->setMotPasse($password);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "participant Ajouté! Good Job.");
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/dashboard.html.twig', [
            'participants'=>$participant,
            'userForm'=>$userForm->createView()
        ]);
    }


    /**
     * @Route("/dashboard/remove/{id}", name= "dashboard_remove")
     */
    public function dashboardRemove(Participant $participant,
                                    ParticipantRepository $participantRepository,
                                    EntityManagerInterface $entityManager
    )
    {
        $participant = $participantRepository->removeUser($participant);
        $this->addFlash('success', "participant supprimé!");
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/dashboard/desactive/{id}", name= "dashboard_desactive")
     */
    public function dashboardDesactive(Participant $participant, EntityManagerInterface $entityManager)
    {
        if ($etat=$entityManager->getRepository(Participant::class)->findOneBy(['actif'=>'1'])){
            $participant->setActif(0);
            $entityManager->flush();
            $this->addFlash('success', "participant désactivé!");
        }else{
            $this->addFlash('warning', "participant déjà désactivé");
        }
        return $this->redirectToRoute('admin_dashboard');
    }
}
