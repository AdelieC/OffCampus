<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\ProfileImage;
use App\Entity\User;
use App\Form\UserFormType;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('dashboard');
        }
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $user = new User();
        $form = $this->createForm(UserFormType::class,
            $user, ['campus_list' => $campusList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            // Persisting user entity first -> its id is generated
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            // Uploading the file to the right directory, with a clean name
            $imageUploader = new ImageUploader($this->getParameter('profile_img_dir'));
            $name = $form->get('userName')->getData();
            $imageFileName = $imageUploader->upload($form->get('profileImage')->getData(), $name);

            // Saving new image's name in db table
            $imageEntity = new ProfileImage();
            $imageEntity->setName($imageFileName);
            $user->setProfileImage($imageEntity);
            $entityManager->persist($user->getProfileImage());
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'registrationForm' => $form->createView()
        ]);
    }
}