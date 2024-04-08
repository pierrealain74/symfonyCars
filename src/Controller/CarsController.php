<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarsController extends AbstractController
{

     #[Route('/cars/', name: 'cars.index')]
     public function index(CarsRepository $repository, Request $request): Response
     {

        $cars = $repository->findAll();

         return $this->render('pages/cars/index.html.twig', [
             'cars' => $cars
         ]);


     }

     #[Route('/cars/nouveau', name: 'cars.new', methods: ['GET', 'POST'])]
     public function new(Request $request, EntityManagerInterface $manager): Response
     {
         $cars = new Cars();
         $form = $this->createForm(CarsType::class, $cars);
 
         $form->handleRequest($request);

         if ($form->isSubmitted() and $form->isValid()) {
 
             //dd($form->getData());
             $cars = $form->getData();
             $manager->persist($cars);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Voiture correctement insérée :)'
             );
 
             return $this->redirectToRoute('cars.index');
         } else {
 
             $this->addFlash(
                 'notice',
                 'Voiture déjà insérée ou donnée manquante :)'
             );
         }
 
         return $this->render
         (
             'pages/cars/new.html.twig', [
             'form' => $form->createView(),
             ]
         );
     }
}
