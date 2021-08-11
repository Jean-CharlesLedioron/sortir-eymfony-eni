<?php

namespace App\Controller;

use App\Entity\SearchFilter;
use App\Form\SearchFilterType;
use App\Repository\CampusRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/home", name="main_home")
     */
    public function home(SortieRepository $sortieRepository, Request $request) : Response
    {
        $searchFilter = new SearchFilter();
        $form = $this->createForm(SearchFilterType::class,$searchFilter);
        $form->handleRequest($request);
       // dd($searchFilter);
        $userConnected = $this->getUser();
        $sorties = $sortieRepository->findSearch($searchFilter,$userConnected);
        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
            'form'=>$form->createView()
        ]);
    }
}