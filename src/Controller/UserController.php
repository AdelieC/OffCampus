<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/edit", name="edit_account")
     */
    public function edit(Request $request): Response
    {
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class,
            $user, ['campus_list' => $campusList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->getUser()->getPassword());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('account');
        }
        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'registrationForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/user/view/{id}", name="view_user")
     */
    public function view(int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('user/view.html.twig', [
            'controller_name' => 'UserController',
            'target_user' => $user
        ]);
    }
    /**
     * @Route("/user/account", name="account")
     */
    public function account(): Response
    {
        return $this->render('user/account.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }
    /**
     * @Route("/user/delete", name="delete")
     */
    public function delete(): Response
    {
        return $this->redirectToRoute('home');
    }
}
