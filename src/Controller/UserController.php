<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    #[Route('/utilisateur/detail/{id}', name: 'user.detail')]
    public function detail(UserRepository $repository, Request $request, int $id): Response
    {
        $user = $repository->find($id);

        //dd($user);

        return $this->render('pages/user/detail.html.twig', [
            'user' => $user
        ]);
    }





    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(User $user, int $id, Request $request, EntityManagerInterface $manager): Response
    {

        /**
         * if user is not loggedin
         */
        if (!$this->getUser()) {

            return $this->redirectToRoute('security.login');
        }

        
        /**
         * if user is not the right user (id=42 logged but want to edit id=41)
         */
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('cars.index');
        }

        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Utilisateur correctement modifié :)'
            );

            return $this->redirectToRoute('user.detail', ['id' => $id]);

        } else {

            $this->addFlash(
                'notice',
                'Utilisateur déjà modifié ou données manquantes'
            );

        }


        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);


    }//endof function USER EDIT

}
