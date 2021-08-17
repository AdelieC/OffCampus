<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\ProfileImage;
use App\Entity\User;
use App\Form\ImageFormType;
use App\Form\UserFormType;
use App\Service\ImageUploader;
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
        $form = $this->createForm(UserFormType::class,
            $user, ['campus_list' => $campusList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * @Route("/user/edit/image", name="edit_profile_image")
     */
    public function editImage(Request $request): Response
    {
        $form = $this->createForm(ImageFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Uploading the file to the right directory, with a clean name
            $imageUploader = new ImageUploader($this->getParameter('profile_img_dir'));
            $name = $this->getUser()->getUsername();
            $imageFileName = $imageUploader->upload($form->get('image')->getData(), $name);

            if($imageFileName) {
                // Saving new image's name in db table
                $imageEntity = new ProfileImage();
                $entityManager = $this->getDoctrine()->getManager();
                $imageEntity->setName($imageFileName);
                $this->getUser()->setProfileImage($imageEntity);
                $entityManager->persist($this->getUser()->getProfileImage());
                $entityManager->flush();
            } else {
                //TODO: Handle upload error
            }

            return $this->redirectToRoute('account');
        }

        return $this->render('image/edit.html.twig', [
            'controller_name' => 'UserController',
            'imageForm' => $form->createView()
        ]);
    }
}
