<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET'])]

    public function index(CarsRepository $repository, Request $request, PaginatorInterface $paginatorInterface): Response
    {

/*         //$cars = $repository->findByCarsWithBrand();
       $cars = $repository->findBy([], ['DateCreation' => 'DESC']);
        
        
        return $this->render('pages/home.html.twig',
        [
            'cars' => $cars
        ]);
 */

        $data = $repository->findBy([], ['DateCreation' => 'DESC']);

        $cars = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1), 
            6
        );

         return $this->render('pages/home.html.twig', [
             'cars' => $cars,
         ]);



    }
}
