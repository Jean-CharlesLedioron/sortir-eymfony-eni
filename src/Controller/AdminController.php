<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Ville;
use App\Form\AddCampusType;
use App\Form\AddCityType;
use App\Form\CampusSearchType;
use App\Form\VilleSearchType;
use App\Model\SearchFilter;
use App\Repository\CampusRepository;
use App\Repository\VilleRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name= "admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/ville", name= "ville")
     */
    public function ville(EntityManagerInterface $entityManager,VilleRepository $villeRepository, Request $request): Response
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
        }

        return $this->render('admin/ville.html.twig', [
            'villes'=>$villes,
            'formVille'=>$form->createView(),
            'addvilleForm' => $villeForm->createView()
        ]);
    }

    /**
     * @Route("/campus", name= "campus")
     */
    public function campus(EntityManagerInterface $entityManager,CampusRepository  $campusRepository, Request $request): Response
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
        }

        return $this->render('admin/campus.html.twig', [
            'campus'=>$campus,
            'formCampus'=>$form->createView(),
            'addcampusForm' => $campusForm->createView()
        ]);
    }
}
