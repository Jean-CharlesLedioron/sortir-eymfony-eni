<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/home", name="main_home")
     */
    public function home(CampusRepository $campusRepository) : Response
    {
        $campusList = $campusRepository->findAll();
        return $this->render('main/home.html.twig', [
            "campusList" => $campusList
        ]);
    }
}