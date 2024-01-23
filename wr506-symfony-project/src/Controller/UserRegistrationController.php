<?php

// // src/Controller/UserRegistrationController.php
// namespace App\Controller;

// use App\Entity\User;
// use App\Form\UserType;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// class UserRegistrationController extends AbstractController
// {
//     #[Route('/api/register', name: 'user_register')]
//     public functin register(Request $request): Response
//     {
//         $user = new User();
//         $form = $this->createForm(UserType::class, $user);

//         $form->handleRequest($request);
//         if ($form->isSubmitted() && $form->isValid()) {
//             $entityManager = $this->getDoctrine()->getManager();
//             $entityManager->persist($user);
//             $entityManager->flush();

//             return $this->redirectToRoute('app_login');
//         }

//         return $this->render('registration/register.html.twig', [
//             'form' => $form->createView(),
//         ]);
//     }
// }
