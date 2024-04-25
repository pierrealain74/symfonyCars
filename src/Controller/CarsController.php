<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;

use Doctrine\ORM\EntityManager;

use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CarsController extends AbstractController
{

 /*    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    } */

     #[Route('/cars/', name: 'cars.index')]
     public function index(CarsRepository $repository, Request $request): Response
     {

        //$cars = $repository->findAll();
        $cars = $repository->findBy([], ['DateCreation' => 'DESC']);

         return $this->render('pages/cars/index.html.twig', [
             'cars' => $cars
         ]);


     }




     #[Route('/cars/detail/{id}', name: 'cars.detail', methods: ['GET', 'POST'])]
     public function details(CarsRepository $repository, Request $request, int $id): Response
     {

        $cars = $repository->find($id);

         return $this->render('pages/cars/detail.html.twig', [
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

            $images = $form->get('images')->getData();
            foreach($images as $image){//on récupèuyre toutes les images

                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $cars->addImage($img);
                
            }

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

     #[Route('/cars/edit/{id}', name: 'cars.edit', methods: ['GET', 'POST'])]
     public function edit(Cars $cars, Request $request, EntityManagerInterface $manager): Response
     {
 
         //paramConverter => id
 
 
         //$cars = new Cars();
     
         $form = $this->createForm(CarsType::class, $cars);
 
         $form->handleRequest($request);
 
         if ($form->isSubmitted() and $form->isValid()) {
 
             $images = $form->get('images')->getData();
             foreach($images as $image){//on récupèuyre toutes les images
 
                 $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                 $image->move(
                     $this->getParameter('images_directory'),
                     $fichier
                 );
 
                 $img = new Images();
                 $img->setName($fichier);
                 $cars->addImage($img);
                 
             }
 
 
 
             //dd($form->getData());
             $cars = $form->getData();
             $manager->persist($cars);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Voiture correctement modifié :)'
             );
 
             return $this->redirectToRoute('cars.index');
         } else {
 
             $this->addFlash(
                 'notice',
                 'Voiture déjà modifiée ou donnée manquante :)'
             );
         }
 
         return $this->render
         (
             'pages/cars/edit.html.twig',
             [
                 'cars' => $cars,
                 'form' => $form->createView()
                 ]
 
         );
     }
 
/**
 * 
 * Delete une image d'un annonce Voiture
 * 
 */

 #[Route('/cars/{id}/images/delete/{imageId}', name:'cars.deleteimg', methods: ['GET', 'POST'])]
 public function deleteImage(int $id, int $imageId, EntityManagerInterface $manager, ImagesRepository $imageRepo): RedirectResponse
 { 
    
    
    //ManagerRegistry $doctrine
    //var_dump($imageId);
    //die();

    //var_dump($image);
    //PARAM CONVERTER Marche pas



    //$data = json_decode($request->getContent(), true);

    // On vérifie si le token est valide
    
        $image = $imageRepo->find($imageId); 
        // On récupère le nom de l'image
        $nom = $image->getName();
        // On supprime le fichier
        unlink($this->getParameter('images_directory').'/'.$nom);

        // On supprime l'entrée de la base
        //$em = $this->$manager->getManager();
        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            'Image supprimée avec succès :)'
        );

        return $this->redirectToRoute('cars.edit', ['id' => $id]);



}





}
