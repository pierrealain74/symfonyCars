<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET'])]

    public function index(CarsRepository $repository): Response
    {

        //$cars = $repository->findByCarsWithBrand();
       $cars = $repository->findAll();
        
        
        return $this->render('pages/home.html.twig',
        [
            'cars' => $cars
        ]);
    }
}
