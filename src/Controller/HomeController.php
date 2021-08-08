<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $campusList = array(
                'Nantes',
                'Niort',
                'Rennes',
                'Quimper'
        );
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class,
            $user, ['campus_list' => $campusList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'registrationForm' => $form->createView(),
        ]);
    }
}